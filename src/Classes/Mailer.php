<?php

namespace Schachbulle\ContaoFideidBundle\Classes;

/**
 * Class Mailer
  */
class Mailer extends \Backend
{

	/**
	 * Versenden einer E-Mail
	 */

	public function send(\DataContainer $dc)
	{
		// E-Mail-Datensatz einlesen
		$mail = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_mails WHERE id = ?")
		                                ->execute($dc->id);
		// Template-Datensatz einlesen
		$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id = ?")
		                                ->execute($mail->template);
		// Spieler-Datensatz einlesen
		$spieler = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE id = ?")
		                                   ->execute($mail->pid);

		$preview = $this->getPreview($dc->id, $mail->pid, $mail->template); // HTML-Vorschau erstellen
		$preview_css = $this->getPreview($dc->id, $mail->pid, $mail->template, true, $css); // HTML/CSS-Version erstellen
		$preview_body = $this->getPreview($dc->id, $mail->pid, $mail->template, false); // Body-Vorschau erstellen

		// E-Mail versenden
		if(\Input::get('token') != '' && \Input::get('token') == $this->Session->get('tl_fideid_send'))
		{

			$this->Session->set('tl_fideid_send', null);
			$objEmail = new \Email();

			$from = html_entity_decode(\Input::get('from'));
			// Empfänger-Adressen in ein Array packen
			//$from = explode(',', html_entity_decode(\Input::get('from')));
			$to = explode(',', html_entity_decode(\Input::get('to')));
			$cc = explode(',', html_entity_decode(\Input::get('cc')));
			$bcc = explode(',', html_entity_decode(\Input::get('bcc')));

			// Führende und abschließende Leerzeichen entfernen, und leere Elemente entfernen
			//$from = array_filter(array_map('trim', $from));
			$to = array_filter(array_map('trim', $to));
			$cc = array_filter(array_map('trim', $cc));
			$bcc = array_filter(array_map('trim', $bcc));

			// Absender "Name <email>" in ein Array $arrFrom aufteilen
			preg_match('~(?:([^<]*?)\s*)?<(.*)>~', $from, $arrFrom);
			
			//print_r($arrFrom);
			

			// Adressen validieren, Exception bei ungültiger Adresse
			if($to && is_array($to))
			{
				foreach($to as $email)
				{
					if(!self::validateEmail($email))
					{
						throw new \Exception(sprintf($GLOBALS['TL_LANG']['Lizenzverwaltung']['emailCorrupt'], $email));
					}
				}
			}
			if($cc && is_array($cc))
			{
				foreach($cc as $email)
				{
					if(!self::validateEmail($email))
					{
						throw new \Exception(sprintf($GLOBALS['TL_LANG']['Lizenzverwaltung']['emailCorrupt'], $email));
					}
				}
			}
			if($bcc && is_array($bcc))
			{
				foreach($bcc as $email)
				{
					if(!self::validateEmail($email))
					{
						throw new \Exception(sprintf($GLOBALS['TL_LANG']['Lizenzverwaltung']['emailCorrupt'], $email));
					}
				}
			}

			log_message('From:','fideid_email.log');
			log_message(print_r($arrFrom,true),'fideid_email.log');

			$objEmail->from = $arrFrom[2];
			$objEmail->fromName = $arrFrom[1];
			$objEmail->subject = $mail->subject;
			$objEmail->html = $preview_css;
			if($cc[0]) $objEmail->sendCc($cc);
			if($bcc[0]) $objEmail->sendBcc($bcc);
			$status = $objEmail->sendTo($to);
			if($status)
			{
				// Versanddatum, Text und Absender/Empfänger in Datenbank eintragen
				$set = array
				(
					'sent_date'  => time(),
					'sent_state' => 1,
					'sent_text'  => $preview_body,
					'sent_from'  => $arrFrom[1].' <'.$arrFrom[2].'>',
					'sent_to'    => $to,
					'sent_cc'    => $cc,
					'sent_bcc'   => $bcc,
				);
				$spieler = \Database::getInstance()->prepare("UPDATE tl_fideid_mails %s WHERE id = ?")
				                                   ->set($set)
				                                   ->execute($dc->id);
				// Email-Versand bestätigen und weiterleiten
				\Message::addConfirmation('E-Mail versendet');
				// Zurücklink generieren, ab C4 ist das ein symbolischer Link zu "contao"
				if (version_compare(VERSION, '4.0', '>='))
				{
					$backlink = \System::getContainer()->get('router')->generate('contao_backend');
				}
				else
				{
					$backlink = 'contao/main.php';
				}
				\Controller::redirect($backlink.'?do='.\Input::get('do').'&table='.\Input::get('table').'&id='.$mail->pid);
			}
			exit;
		}

		// E-Mail-Empfänger festlegen
		if($spieler->antragsteller_ungleich_person)
		{
			// Antragsteller und Auftraggeber sind unterschiedlich
			$email_to = htmlentities($spieler->vorname_person.' '.$spieler->nachname_person.' <'.$spieler->email_person.'>');
			$email_cc = htmlentities($spieler->vorname.' '.$spieler->nachname.' <'.$spieler->email.'>');
			$email_bcc = '';
		}
		else
		{
			// Antragsteller und Auftraggeber sind gleich
			$email_to = htmlentities($spieler->vorname.' '.$spieler->nachname.' <'.$spieler->email.'>');
			$email_cc = '';
			$email_bcc = '';
		}

		$strToken = md5(uniqid(mt_rand(), true));
		$this->Session->set('tl_fideid_send', $strToken);

		return
		'<div id="tl_buttons">
<a href="'.$this->getReferer(true).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>
'.\Message::generate().'
<form action="'.TL_SCRIPT.'" id="tl_fideid_send" class="tl_form" method="get">
<div class="tl_formbody_edit tl_fideid_send">
<input type="hidden" name="do" value="' . \Input::get('do') . '">
<input type="hidden" name="table" value="' . \Input::get('table') . '">
<input type="hidden" name="key" value="' . \Input::get('key') . '">
<input type="hidden" name="id" value="' . \Input::get('id') . '">
<input type="hidden" name="token" value="' . $strToken . '">
<div class="tl_preview">
<table class="prev_header">
  <tr class="row_0">
    <td class="col_0"><b>Betreff:</b></td>
    <td class="col_1">' . $mail->subject . '</td>
  </tr>
  <tr class="row_1">
    <td class="col_0"><b>E-Mail-Template:</b></td>
    <td class="col_1">' . $tpl->name . '</td>
  </tr>
</table>
</div>
<div class="tl_preview">' .$preview_body. '</div>

<div class="tl_tbox">
<div class="long widget">
  <h3><label for="ctrl_an">From (Absender)<span class="mandatory">*</span></label></h3>
  <input type="text" name="from" id="ctrl_an" value="'.$GLOBALS['TL_CONFIG']['fideidverwaltung_absender'].'" class="tl_text" onfocus="Backend.getScrollOffset()">
  <p class="tl_help tl_tip">Pflichtfeld: Absender dieser E-Mail.</p>
</div>
<div class="long widget">
  <h3><label for="ctrl_an">To (Empfänger)<span class="mandatory">*</span></label></h3>
  <input type="text" name="to" id="ctrl_an" value="'.$email_to.'" class="tl_text" onfocus="Backend.getScrollOffset()">
  <p class="tl_help tl_tip">Pflichtfeld: Empfänger dieser E-Mail. Weitere Empfänger mit Komma trennen.</p>
</div>
<div class="long widget">
  <h3><label for="ctrl_cc">Cc (Kopie-Empfänger)</label></h3>
  <input type="text" name="cc" id="ctrl_cc" value="'.$email_cc.'" class="tl_text" onfocus="Backend.getScrollOffset()">
  <p class="tl_help tl_tip">Kopie-Empfänger dieser E-Mail. Weitere Empfänger mit Komma trennen.</p>
</div>
<div class="long widget">
  <h3><label for="ctrl_bcc">Bcc (Blindkopie-Empfänger)</label></h3>
  <input type="text" name="bcc" id="ctrl_bcc" value="'.$email_bcc.'" class="tl_text" onfocus="Backend.getScrollOffset()">
  <p class="tl_help tl_tip">Blindkopie-Empfänger dieser E-Mail. Weitere Empfänger mit Komma trennen.</p>
</div>
<div class="clear"></div>
</div>
</div>
<div class="tl_formbody_submit">
<div class="tl_submit_container">
'.($mail->sent_state ? '<span class="mandatory">Die E-Mail wurde bereits gesendet!</span>' : '<input type="submit" onclick="return confirm(\'Soll die E-Mail wirklich verschickt werden?\')" value="E-Mail versenden" accesskey="s" class="tl_submit" id="send">').'
</div>
</div>
</form>';

	}


	public function getPreview($mail_id, $spieler_id, $template, $header = true, $css = false)
	{
		// Template-Datensatz einlesen
		$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id = ?")
		                               ->execute($template);

		// Mail-Datensatz einlesen
		$mail = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_mails WHERE id = ?")
		                                ->execute($mail_id);

		// Spieler-Datensatz einlesen
		$spieler = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE id = ?")
		                                   ->execute($spieler_id);

		$arrTokens = array
		(
			'status'                        => $spieler->status,
			'formulardatum'                 => date('d.m.Y H:i', $spieler->formulardatum),
			'antragsteller_ungleich_person' => $spieler->antragsteller_ungleich_person,
			'nachname_person'               => $spieler->nachname_person,
			'vorname_person'                => $spieler->vorname_person,
			'email_person'                  => $spieler->email_person,
			'art'                           => $spieler->art,
			'nachname'                      => $spieler->nachname,
			'vorname'                       => $spieler->vorname,
			'titel'                         => $spieler->titel,
			'geburtsdatum'                  => date('d.m.Y', $spieler->geburtsdatum),
			'geschlecht'                    => $spieler->geschlecht,
			'email'                         => $spieler->email,
			'fide_id'                       => $spieler->fide_id,
			'nuligalight'                   => $spieler->nuligalight,
			'datenschutz'                   => $spieler->datenschutz,
			'verein'                        => $spieler->verein,
			'ausweis'                       => $spieler->ausweis,
			'elterneinverstaendnis'         => $spieler->elterneinverstaendnis,
			'turnier'                       => $spieler->turnier,
			'germany'                       => $spieler->germany,
			'bemerkungen'                   => $spieler->bemerkungen,
			'intern'                        => $spieler->intern,
			'subject'                       => $mail->subject,
			'content'                       => $mail->content,
			'signatur'                      => $GLOBALS['TL_CONFIG']['fideidverwaltung_mailsignatur'],
		);

		$content = $tpl->template;
		$content = \StringUtil::restoreBasicEntities($content); // [nbsp] und Co. ersetzen
		$content = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($content, $arrTokens);

		if($header)
		{
			// Mit HTML-Header zurückgeben
			return $content;
		}
		else
		{
			// Nur Body-Tag zurückgeben
			preg_match('/<body>(.*)<\/body>/s', $content, $matches); // Body extrahieren
			return $matches[1];
		}

	}

	function validateEmail($email)
	{
		// Prüfen ob Email im Format "Name <Adresse>" vorliegt, ggfs. $email ändern vor der Validierung
		preg_match('~(?:([^<]*?)\s*)?<(.*)>~', $email, $result);
		
		if(isset($result[2])) $email = $result[2];
		
		return filter_var($email, FILTER_VALIDATE_EMAIL);

	}

}
