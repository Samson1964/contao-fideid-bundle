<?php

namespace Schachbulle\ContaoFideidBundle\Classes;

/**
 * Class Mailer
  */
class Speedmailer extends \Backend
{

	/**
	 * Sofortiges Versenden einer E-Mail
	 */

	public function send()
	{

		if(\Input::get('key') != 'getMailbuttons') return; // Nicht unser Schlüssel

		$antrag_id = \Input::get('antrag'); // ID des Antrags
		$tpl_id = \Input::get('template'); // ID des Templates

		if($antrag_id && $tpl_id)
		{
			// Spieler-Datensatz einlesen
			$spieler = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE id=?")
			                                   ->execute($antrag_id);
			// Template-Datensatz einlesen
			$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id=?")
			                               ->execute($tpl_id);

			// Betreffzeile festlegen
			$subject = $tpl->subject;

			$this->Session->set('tl_fideid_send', null);
			$objEmail = new \Email();

			// Absender
			$from = $GLOBALS['TL_CONFIG']['fideidverwaltung_absender'];
			// Absender "Name <email>" in ein Array $arrFrom aufteilen
			preg_match('~(?:([^<]*?)\s*)?<(.*)>~', $from, $arrFrom);

			// Empfänger festlegen
			$to = ''; $cc = '';
			if($spieler->email_person)
			{
				// Auftraggeber-Mail vorhanden
				$to = explode(',', $spieler->vorname_person.' '.$spieler->nachname_person.' <'.$spieler->email_person.'>');
				if($spieler->email && $spieler->email != $spieler->email_person)
				{
					// Antragsteller-Mail vorhanden und nicht identisch mit Auftraggeber-Mail
					$cc = explode(',', $spieler->vorname.' '.$spieler->nachname.' <'.$spieler->email.'>');
				}
			}
			else
			{
				// Auftraggeber nicht vorhanden
				if($spieler->email)
				{
					// Antragsteller-Mail vorhanden
					$to = explode(',', $spieler->vorname.' '.$spieler->nachname.' <'.$spieler->email.'>');
				}
			}

			if($to)
			{
				// Mail kann verschickt werden
				// Führende und abschließende Leerzeichen entfernen, und leere Elemente entfernen
				$to = array_filter(array_map('trim', $to));
				if($cc) $cc = array_filter(array_map('trim', $cc));

				// Adressen validieren, Exception bei ungültiger Adresse
				if($to && is_array($to))
				{
					foreach($to as $email)
					{
						if(!self::validateEmail($email))
						{
							throw new \Exception(sprintf($GLOBALS['TL_LANG']['Fideid']['emailCorrupt'], $email));
						}
					}
				}
				if($cc && is_array($cc))
				{
					foreach($cc as $email)
					{
						if(!self::validateEmail($email))
						{
							throw new \Exception(sprintf($GLOBALS['TL_LANG']['Fideid']['emailCorrupt'], $email));
						}
					}
				}

				$preview_css = $this->getPreview($antrag_id, $tpl_id, true, $css); // HTML/CSS-Version erstellen
				$preview_body = $this->getPreview($antrag_id, $tpl_id, false); // Body-Vorschau erstellen
				$subject = $this->getSubject($antrag_id, $tpl_id, $subject); // Tokens im Betreff ersetzen

				$objEmail->from = $arrFrom[2];
				$objEmail->fromName = $arrFrom[1];
				$objEmail->subject = $subject;
				$objEmail->html = $preview_css;
				if($cc) $objEmail->sendCc($cc);
				$status = $objEmail->sendTo($to);
				if($status)
				{
					// Mail in Datenbank eintragen
					$set = array
					(
						'tstamp'     => time(),
						'pid'        => $antrag_id,
						'template'   => $tpl_id,
						'sent_date'  => time(),
						'sent_state' => 1,
						'sent_text'  => $preview_body,
						'sent_from'  => $from,
						'sent_to'    => $to,
						'sent_cc'    => $cc,
					);
					$email = \Database::getInstance()->prepare("INSERT INTO tl_fideid_mails %s")
					                                 ->set($set)
					                                 ->execute($id);
					// Email-Versand bestätigen und weiterleiten
					\Message::addConfirmation('E-Mail versendet');
				}
				else
				{
					// Email-Versand bestätigen und weiterleiten
					\Message::addError('Fehler '.$status.' beim Versand, E-Mail nicht versendet');
				}
			}
			else
			{
				// Kein Empfänger, Mail nicht versenden
				\Message::addError('Kein Empfänger, E-Mail nicht versendet');
			}

		}

		// Zurücklink generieren
		$backlink = \System::getContainer()->get('router')->generate('contao_backend');
		\Controller::redirect($backlink.'?do='.\Input::get('do').'&act=edit&table='.\Input::get('table').'&rt='.\Input::get('rt').'&id='.$antrag_id);
		exit;

	}


	public function getPreview($spieler_id, $template, $header = true, $css = false)
	{
		// Template-Datensatz einlesen
		$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id = ?")
		                               ->execute($template);

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
			'subject'                       => $tpl->subject,
			'content'                       => '',
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

	public function getSubject($spieler_id, $template, $subject)
	{
		// Template-Datensatz einlesen
		$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id = ?")
		                               ->execute($template);

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
			'subject'                       => $tpl->subject,
			'signatur'                      => $GLOBALS['TL_CONFIG']['fideidverwaltung_mailsignatur'],
		);

		$subject = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($tpl->subject, $arrTokens);
		return $subject;

	}

	function validateEmail($email)
	{
		// Prüfen ob Email im Format "Name <Adresse>" vorliegt, ggfs. $email ändern vor der Validierung
		preg_match('~(?:([^<]*?)\s*)?<(.*)>~', $email, $result);

		if(isset($result[2])) $email = $result[2];

		return filter_var($email, FILTER_VALIDATE_EMAIL);

	}
}
