<?php
//session_start();
//require "config.php";

//require "functions.php";


session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<!-- rounded corners for IE -->
<script src="DD_roundies_0.0.2a-min.js"></script>
<script>
DD_roundies.addRule("#nav", "5px");
DD_roundies.addRule("#nav li", "5px");
</script>
<script>
$(document).ready(function(){
	$nav_li=$("#nav li");
	$nav_li_a=$nav_li.children("a");
	var animSpeed=450; //fade speed
	var hoverTextColor="#fff"; //text color on mouse over
	var hoverBackgroundColor="#9e0039"; //background color on mouse over
	var textColor=$nav_li_a.css("color");
	var backgroundColor=$nav_li.css("background-color");
	$nav_li_a.hover(function() {
		var $this=$(this);
		$this.stop().animate({ color: hoverTextColor }, animSpeed).parent().stop().animate({ backgroundColor: hoverBackgroundColor }, animSpeed);
	},function() {
		var $this=$(this);
		$this.stop().animate({ color: textColor }, animSpeed).parent().stop().animate({ backgroundColor: backgroundColor }, animSpeed);
	});
});
</script>

</head>
<body>
<?php
require "config2.php";
//$con = mysqli_connect("athena.fhict.nl", "dbi271234", "gR2mFIKQcm","dbi271234");
// Check connection

$error = '';


if(isset($_POST['reg']))
{    
	 $check = true;
     $firstname = addslashes($_POST['firstname']);
     $lastname = addslashes($_POST['lastname']);
     $pass1 = addslashes($_POST['pass1']);
     $pass2 = addslashes($_POST['pass2']);
     $email = addslashes($_POST['email']);
	 $date = date("Y-m-d");
	 $gender = $_POST['gender'];
	 $country = $_POST['country'];
	 $dob= $_POST['year_of_birth'] . '-' . $_POST['month_of_birth'] . '-' . $_POST['day_of_birth'];
	 
	 
		
if ($firstname&md5($pass1)&&$pass2&&$email&&$date&&$country&&$dob&&$lastname)
     
     {
        
        
          if(strlen($pass1)>=6)
          {
            if($pass1==$pass2)
            {
			  if (isset ($_POST['gender']))
				{
             $emailcheck = mysql_query("SELECT id FROM users1 WHERE email='$email'"); 
			 $count2 = mysql_num_rows($emailcheck);
			 if ($count2!=0)
			 {
				$error= "<u>The email address is already used!</u>";
			 }
			 else
				if( !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$/",$email) )
			 {
				$error = "<u>The email address is not valid!</u>";
			 }
			 else {
				
                $random = rand(23456789,98765432);

             
                $newPass = md5($pass1);
                $query = mysql_query("INSERT INTO users1 (firstname,lastname,password,email,date,gender,dob,country,random,activated) VALUES('$firstname','$lastname','$newPass','$email','$date','$gender','$dob','$country','$random','0')
                ");
				
				$query = mysql_query("INSERT INTO eventaccount(balance,CampingSpot_camping_spot_id) VALUES(0, NULL)");
				

				$lastid = mysql_insert_id();


		
				
					$to = $email;
					$subject = "Registration validation";
					$Message = " Hello $firstname $lastname, \n\n
                   
                   You have to activate your account by clicking the link below.
				   http://athena.fhict.nl/users/i272798/tester2/activate.php?id=$lastid&code=$random \n\n
                   
				   Your ID is $lastid ! You will need it for booking a camping spot!
                   Thank you! ";
		$from = "admin@funtysmind.nl";
		$headers = "From:". $from;
		mail ($to,$subject,$Message,$headers);

                echo "<div style='width:auto;height:auto;margin:0 auto;text-align:center;font-size:14pt;color:#9e0039;'>You have registered successfully! Check your email address <b>($email)</b> in order to activate your account!</div>";
	   }	
	   }
	  
	   
	      else{
				$error = "<u>You must specify the gender!</u>";
				}	
           
          }
		   else
            {
             $error = "<u>The passwords do not match!</u>";
            }
          
        }
		else
          {
           $error="<u>Your password has to be at least 6 characters!</u>";
          }
		
}
    
	 
     else
     {
      $error = "<u>Please fill all the fields</u>";
     }
	

/* if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
echo "1 record added";


mysqli_close($con); */
}
?>





	 
	 
		
 
             

            



<div id="nav">
	<ul>
    	<li><a href="info.php">Info</a></li>
        <li><a href="Line-up.php">LineUp</a></li>
		<li><a href="form.php">Buy A Ticket</a></li>
        <?php if(!isset($_SESSION['email'])){
        echo "<li><a href='ticketdeal.php'>Profile</a></li>";}
		else { echo "<li><a href='member.php'>Profile</a></li>";} ?>
        <li><a href="camping.php">Camping</a></li>
        <li><a href="faq.php">FAQ</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="logo"><a href="index.php"><img src="img/logo.jpg"></a></div>
<div id="cont">
<div id="title"><h2>Buy A Ticket</h2></div>
<div id="error"><?php echo "<b> $error </b>"; ?></div>





	<form action="form.php" method="post">
	<table cellspacing="20">
	<tr>
		<td>First Name: </td><td><input type="text" name="firstname"  <?php if (isset($_POST['firstname']) === true) {echo 'value="', strip_tags($_POST['firstname']),'"'; }?>class="bg" ></td>		
		</tr>
		
		<tr>
		<td>Last Name: </td><td><input type="text" name="lastname" size="40" maxlength="40" <?php if (isset($_POST['lastname']) === true) {echo 'value="', strip_tags($_POST['lastname']),'"'; }?> class="bg" ></td>		
		</tr>
		<tr>
		<td>Password: </td><td><input type="password" name="pass1" size="40" maxlength="40" class="bg"></td>		
		</tr>
		<tr>
		<td>Repeat your password: </td><td><input type="password" name="pass2" size="40" maxlength="40" class="bg"></td>		
		</tr>
		<tr>
		<td>Email:</td><td><input type="text" name="email" size="40" maxlength="40" <?php if (isset($_POST['email']) === true) {echo 'value="', strip_tags($_POST['email']),'"'; }?> class="bg" ></td>		
		</tr>
		<tr>
		<td>Gender</td><td><input type="radio" name="gender" value="M" checked="checked"/>M
						   <input type="radio" name="gender" value="F"/>F
					  </td>		
		</tr>
		<tr>
		<td>Date of Birth: </td><td>
                    <select id="form_dob_month" name="month_of_birth" oninvalid="setCustomValidity('Please choose your DOB!')" required>
                        
<?php 
$months = array(1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December");

foreach($months as $key => $value) {
 echo    "<option value=" . $key . ">" . $value . "</option>";
}
?>
</select>

 <select id="form_dob_day" name="day_of_birth" oninvalid="setCustomValidity('Please choose your DOB!')" required>

	

<?php 
 for($n = 1; $n <= 31; $n++) {
        echo "<option value =" . $n . ">".$n."</option>";
        }
?>
</select>

 <select id="form_dob_year" name="year_of_birth" oninvalid="setCustomValidity('Please choose your DOB!')" required>

	
<?php 
 for($n = 2012; $n >1950; $n--) {
        echo "<option value =" . $n . ">".$n."</option>";
        }
?>
	
</select></td>		
		</tr>
		<tr>
		<td>Country: </td><td><select name="country" required>
<option value="">Country...</option>
<option value="Afganistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome & Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America">United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select></td>		
		</tr><tr>
		<td></td><td><div id="terms">
		<p>By clicking "I agree" you accept that you will recieve an e-mail, containing a Bank account, in which you are required to send the money for the ticket.</p>
		<p>If money is not transferred in 2 weeks, the created account will be terminated!</p>
		<p>
Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
<p>
Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
<p>
Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
</div></td>		
		</tr>
		
		
		
		
		
		</div>
		   
		
		
		
		
		<!-- PUT BEFORE FORM CODE -->
<script type="text/javascript">
agreeTerms = function(v){
 var submitButton = document.getElementById("submit_button");
 if(v.checked == true){
  submitButton.disabled = false;
 }else{
  submitButton.disabled = true;
 }
}//end function agreeTerms()
</script>
<tr><td></td><td><input type="checkbox" id="TOS" value="1" onClick="agreeTerms(this)">I agree<br>
<input type="submit" VALUE="  Buy Ticket  " id="submit_button" name="reg" disabled >
<input type="button" value="Clear" > </td></tr> </td></tr>
		

</table>
</form>
   


</div>
	
<div id="footer">
 <table style="width:680px;margin:0 auto;">
  <tr>
   <td align="left"><iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFuntysFestival2013&amp;width=220&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:62px;" allowTransparency="true"></iframe></td><td><h3 style="color:white;">Copyright &#169; 2013  Funtys Mind Ltd.</h3></td><td><a href="https://twitter.com/share" class="twitter-share-button" data-url="https://twitter.com/FuntysFestival">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></td></tr></table>
   
 
 
 </footer>	
	
	
	</body>
</html>

