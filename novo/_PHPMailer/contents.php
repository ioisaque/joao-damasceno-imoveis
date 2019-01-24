<?php 
function getBody($nome, $email, $mensagem) 
{
return '
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
</head>

<body>

  <!--Main Table Start-->
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-size: .9rem; letter-spacing: .05em; line-height: 1.3rem; color: #19308A;">
    <tr>
      <td align="center" valign="top">

        <repeater>

          <!--logo part Start-->
          <layout label="1-logo part">

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" mc:repeatable="littlemail"
              mc:variant="1-logo part">
              <tr>
                <td align="center" valign="top">
                  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF" style="border: 2px solid #0789b8;border-bottom: none;border-radius: 10px 10px 0px 0px;background:#FFF;">
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
                          <tr>
                            <td height="25" align="left" valign="top" style="line-height:25px;"><img src="http://www.sige.pro.br/marketing/images/space.png"
                                width="4" height="4" alt="" style="display:block;" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">

                              <table border="0" align="center" cellpadding="0" cellspacing="0" class="full">
                                <tr>
                                  <td align="center" valign="top"><a href="http://www.sige.pro.br"><img mc:edit="lm-01" editable="true" src="http://www.sige.pro.br/marketing/images/topFormMailLogo.png"
                                      height="80" alt="" style="display:block;" /></a></td>
                                </tr>
                              </table>

                            </td>
                          </tr>
                          <tr>
                            <td height="25" align="left" valign="top" style="line-height:25px;"><img src="http://www.sige.pro.br/marketing/images/space.png"
                                width="4" height="4" alt="" style="display:block;" /></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

          </layout>

          <!--Footer part Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" mc:repeatable="littlemail"
              mc:variant="57-Footer 2 contact part">
              <tr>
                <td align="center" valign="top">
                  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="300" align="center" valign="middle" style="border: 2px solid #0789b8;border-top: none;border-radius: 0px 0px 10px 10px;background:#FFF;">						
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
                          <tr>
                            <td align="left" valign="top">
								<p>									
									<b>Nome:</b> 		'.$nome.'<br>
									<b>E-mail:</b> 		<a href="mailto:'.$email.'">'.$email.'</a><br>
									<b>Mensagem:</b>
									<br>'.$mensagem.'
								</p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

          </layout>

          <!--Footer part End-->

      </td>
    </tr>
  </table>
  <!--Main Table End-->
</body>

</html>';
}
?>