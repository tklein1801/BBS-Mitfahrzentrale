<?php
namespace DulliAG\System;

class Mailer
{
  public $defaultHeader = array(
    'From: webmaster@example.com',
    'Reply-To: webmaster@example.com',
    'Content-type: text/html;charset=UTF-8'
  );
  public $settings = array(
    'host' => 'http://88.214.58.211/',
    'footer' => array(
      'link' => 'https://github.com/tklein1801/BBS-Mitfahrzentrale/',
      'text' => '© Thorben Klein'
    )
  );

  public function headersToString(array $headers) 
  {
    $headerString = "";
    foreach ($headers as $header) {
      $headerString .= $header . "\r\n";
    }
    return $headerString;
  }

  public function create(string $hero_title, string $intro, string $content = null, string $outro = null)
  {
    $head = '<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
      <link rel="preconnect" href="https://fonts.gstatic.com" />
      <link
        href="https://fonts.googleapis.com/css2?family=Hind+Madurai:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
      />
      <style type="text/css">
        * {
          margin: 0;
        }
        html, body {
          width: 100%;
          font-family: "Hind Madurai", sans-serif;
          font-size: 1.1rem;
          font-weight: 400;
        }
        .link {
          text-decoration: none;
          font-weight: normal;
        }   
        .ReadMsgBody {
          width: 100%;
          background-color: #f1f1f1;
        }   
        .ExternalClass {
          width: 100%;
          background-color: #f1f1f1;
        }   
        a {
          color: #ffcccc;
          text-decoration: none;
          font-weight: normal;
          font-style: normal;
        }    
        p,
        div,
        span {
          margin: 0 !important;
        }    
        table {
          border-collapse: collapse;
        }
        @media only screen and (max-width: 599px) {
          body {
            width: auto !important;
          }
          table table {
            width: 100% !important;
          }
          td.paddingOuter {
            width: 100% !important;
            padding-right: 20px !important;
            padding-left: 20px !important;
          }
          td.fullWidth {
            width: 100% !important;
            display: block !important;
            float: left;
            margin-bottom: 30px !important;
          }
          td.fullWidthNM {
            width: 100% !important;
            display: block !important;
            float: left;
            margin-bottom: 0px !important;
          }
          td.center {
            text-align: center !important;
          }
          td.right {
            text-align: right !important;
          }
          td.spacer {
            display: none !important;
          }
          img.scaleImg {
            width: 100% !important;
            height: auto;
          }
        }
      </style>
    </head>';

    $spacer = '<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#004253" style="padding: 0; margin: 0;">
      <tr>
        <td class="paddingOuter" align="center" valign="top" align="center">
          <table class="tableWrap" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" height="30" style="padding:0; line-height: 0;"></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>';

    $header = '<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#023846" style="padding: 0; margin: 0;">
      <tr>
        <td class="paddingOuter" valign="top" align="center" style="padding: 40px 0px;">
          <table class="tableWrap" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding: 0px;">
                <table class="tableInner" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <!-- Logo -->
                    <td class="fullWidth" width="305" align="left" valign="top" style="padding: 0;">
                      <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="center" align="left" valign="top" style="margin: 0; padding-bottom: 0; font-size:14px; font-weight: normal; color:#949494; font-family: "Quicksand", sans-serif!important; line-height: 100%; ">
                            <span>
                              <a href="'.$this->settings['host'].'" class="link" style="color: #e27a00;">
                                <h1 style="float: left; font-weight: bold;">BBS-Mitfahrzentrale</h1>
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <!-- ./Logo -->

                    <!-- Spacer -->
                    <td class="spacer" width="30" height="0" align="left" valign="top" style="font-size: 0; line-height: 0;">
                      &nbsp;
                    </td>
                    <!-- ./Spacer -->

                    <!-- Navigation -->
                    <td class="fullWidthNM" width="305" align="left" valign="middle" style="padding: 0;">
                      <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="center" align="right" valign="middle" style="margin: 0; padding-bottom: 0;">
                            <span>
                              &nbsp;&nbsp;
                              <a href="'.$this->settings['host'].'Anmelden" class="link" style="font-weight: bold; font-size: 1.025rem; color: #e27a00;">
                                Anmelden
                              </a>
                              &nbsp;&nbsp;
                              <a href="'.$this->settings['host'].'Registrieren" class="link" style="font-weight: bold; font-size: 1.025rem; color: #e27a00;">
                                Registrieren
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <!-- ./Navigation -->
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>';

    $hero = '<table width="700" bgcolor="#004253" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="paddingOuter" valign="top" align="center">
          <table class="tableWrap" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding-top: 40px; padding-bottom: 20px;">
                <table class="tableInner" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="fullWidthNM" width="640" align="left" valign="top" style="padding: 0;">
                      <table width="100%" align="left" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center">
                            <table width="100%" align="left" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="210" valign="middle" align="left" height="2" style="padding-bottom: 0;">
                                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" width="100%" height="2" style="background-color: #fff; display: inline-block;">
                                        &nbsp;
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td width="240" align="center" valign="top">
                                  <table border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="100%" align="center" valign="top" style="margin: 0; padding: 0;">
                                        <span class="link" style="font-size: 1.2rem; color: #fff;">
                                          '.$hero_title.'
                                        </span>
                                      </td>
                                    </tr>
                                  </table>
                                </td>                                           
                                <td width="210" valign="middle" align="right" height="2" style="padding-bottom: 0;">
                                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" width="100%" height="2" style="background-color: #fff; display: inline-block;">
                                        &nbsp;
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>';

    $footer = '<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#023846" style="padding: 0; margin: 0;">
      <tr>
        <td class="paddingOuter" valign="top" align="center" style="padding: 0px;">
          <table class="tableWrap" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding: 1.5rem 0;">
                <table class="tableInner" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="fullWidth" width="640" align="center" valign="top" style="margin: 0; padding: 0; line-height: 1rem;">
                      <p style="font-weight: bold; color: #e27a00;">
                        <a href="'.$this->settings['footer']['link'].'" class="link" style="color: #e27a00;">
                          '.$this->settings['footer']['text'].'
                        </a>
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>';

    if (!is_null($intro)) {
      $intro = '<tr>
        <p style="color: #fff;">
          '.$intro.'
        </p>
      </tr>';
    }

    if (!is_null($outro)) {
      $outro = '<tr style="text-align: center;">
        <td>
          <p style="color: #fff;">
            '.$outro.'
          </p>
        </td>
      </tr>';
    }

    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
        '.$head.'
        <body>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f9fa" style="padding: 0; margin: 0;">
            <tr>
              <td align="center" width="700" valign="top">
                '.$header.'

                '.$hero.'                

                <!-- Content -->
                <table width="700" border="0" align="center" cellpadidng="0" cellspacing="0" bgcolor="#004253" style="padding: 0; margin: 0;">
                  <tr>
                    <td class="paddingOuter" align="center" valign="top">
                      <table class="tableWrap" width="640" border="0" align="center" cellpadding="0" cellspacing="0">
                        '.$intro.'

                        '.$content.'

                        '.$outro.'
                      </table>
                    </td>
                  </tr>
                </table>
                <!-- ./Content -->

                '.$spacer.'

                '.$footer.'
              </td>
            </tr>
          </table>
        </body>
      </html>';

    return $message;
  }

  public function send(string $targetEmail, string $subject, string $message, $header = null)
  {
    // It should be enought to check if the the value isn't null to proof if an value was set or not
    if (!is_array($header) && !is_string($header) && is_null($header)) {
      $header = $this->defaultHeader;
    }
    
    if (is_array($header)) {
      $header = $this->headersToString($header); // Transform array to string
    }

    $status = mail($targetEmail, $subject, $message, $header);
    return $status;
  }
}

class MailTemplates extends Mailer
{
  public function verifyEmail(string $verifyUrl)
  {
    $hero = "Willkommen in der BBS-Mitfahrzentrale";
    $intro = "Damit du dein Benutzerkonto der BBS-Mitfahrzentrale vollständig nutzen zu können musst du vorher deine Email Adresse bestätigen. Um deine Email Adresse zu bestätigen musst du nur noch den Link unten anklicken und du wirst automatisch weitergeleitet.";
    $content = '<tr>
      <td>
        <p style="text-align: center; padding: 1rem 0;">
          <a href="'.$verifyUrl.'" style="color: #e27a00;">
            '.$verifyUrl.'
          </a>
        </p>
      </td>
    </tr>';

    $message = $this->create($hero, $intro, $content);

    return $message;
  } 

  public function resetPasswort(string $resetUrl)
  {
    $hero = "Passwort zurücksetzen";
    $intro = "Damit du dein Passwort zurücksetzen kannst folge dem Link welcher unten angeben ist.";
    $content = '<tr>
      <td>
        <p style="text-align: center; padding: 1rem 0;">
          <a href="'.$resetUrl.'" style="color: #e27a00;">
            '.$resetUrl.'
          </a>
        </p>
      </td>
    </tr>';

    $message = $this->create($hero, $intro, $content);

    return $message;
  }
}