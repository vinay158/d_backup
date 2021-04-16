<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<?php 

//$first_name = (isset($_GET['first_name']) && !empty($_GET['first_name'])) ? $_GET['first_name'] : 'NA';
//$last_name = (isset($_GET['last_name']) && !empty($_GET['last_name'])) ? $_GET['last_name'] : 'NA';

$full_name = (isset($_GET['first_name']) && !empty($_GET['first_name'])) ? trim($_GET['first_name']) : '';
				
$first_name = 'N/A';
$last_name = 'N/A';
if(!empty($full_name)){
	$user_full_name = explode(' ',$full_name);
	$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
	
	if(!empty($user_full_name)){
		unset($user_full_name[0]);
	}
	$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
}
				
$email = (isset($_GET['email']) && !empty($_GET['email'])) ? $_GET['email'] : 'test9989@gmail.com';
$phone = (isset($_GET['phone']) && !empty($_GET['phone'])) ? $_GET['phone'] : 'NA';
$mat_category_id = (isset($_GET['mat_category_id']) && !empty($_GET['mat_category_id'])) ? $_GET['mat_category_id'] : '0';
$club_id = (isset($_GET['club_id']) && !empty($_GET['club_id'])) ? $_GET['club_id'] : '0';
$address = '';
$town = '';
$city = '';
$zip_code = '';

?>
<script  src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script>
        
            var apiInfo = {                
                baseAddr: "<?php echo $mat_api->url; ?>",
                token: ""
            };

            $(function(){

                console.log("authentication");

                doLogin();

             
            });          

            function doLogin() {

                var loginData = {
                    grant_type: 'password',
                    username: '<?php echo $mat_api->username; ?>',
                    password: '<?php echo $mat_api->password; ?>'                    
                };

                $.ajax({
                    type: 'POST',
                    url: apiInfo.baseAddr + 'Token',
                    data: loginData
                }).done(function (e) {
                    console.dir(e);
					 apiInfo.token = e.access_token;
					 
					 
					  var headers = getHeaders(),
						prospect = createProspect();
					console.log('headers=>');
					console.log(headers);
					console.log('prospect=>'); 
					console.log(prospect); 
					
					$.ajax({

						url: apiInfo.baseAddr + "api/prospect",
						data: prospect,
						headers: headers,
						type: 'post',
						dataType: 'json'
					}).done(function (e) {
						console.dir(e);
						$("#result").html(e);

					}).fail(function (x, s, e) {

						console.log("error: " + e);
					});
                }).fail(function (x, s, e) {
                    console.log("error: " + e);
                });
            }
        

            function postProspect() {
				
                var headers = getHeaders(),
                    prospect = createProspect();
				console.log('headers=>');
				console.log(headers);
				console.log('prospect=>'); 
				console.log(prospect); 
				
                $.ajax({

                    url: apiInfo.baseAddr + "api/prospect",
                    data: prospect,
                    headers: headers,
                    type: 'post',
                    dataType: 'json'
                }).done(function (e) {
                    console.dir(e);
                    $("#result").html(e);

                }).fail(function (x, s, e) {

                    console.log("error: " + e);
                });
            }

          

			
            function createProspect() {

                var data = createEnquiry(),
                    d = new Date();

                
				data.ClubName = "<?php echo $club_id; ?>";
				data.FirstName = "<?php echo $first_name ?>";
				data.LastName = "<?php echo $last_name ?>";
				data.Email = "<?php echo $email ?>";
				data.PhoneMobile = "<?php echo $phone ?>";
				data.Address1 = "<?php echo $address ?>";
				data.AddressTown = "<?php echo $town ?>";
				data.AddressPostcode = "<?php echo $zip_code ?>";
				data.Category = "<?php echo $mat_category_id; ?>";
                return data;
            }

			function createEnquiry() {

                var data = {
                    FirstName: $("#txtFN").val(),
                    LastName: $("#txtLN").val(),
                    Email: $("#txtEmail").val(),
                    PhoneMobile: "<?php echo $phone ?>",
                    Category: "<?php echo $mat_category_id; ?>",
                    Notes: "",
                    ClubName: "14",
                    //ClubName: "Warrior Martial Arts",
                    Discipline: "11",
                    Campaign: "eb36",
                    //Campaign: "eb31",
                    AgreeSMS: 1,
                    AgreeEmail: 1,
                    AgreeOther: 1,
					Age: 10
                }

                return data;
            }

           
            function getHeaders() {
                
                var headers = {};
                if (apiInfo.token) {
                    headers.Authorization = 'Bearer ' + apiInfo.token;
                }
                return headers;
            }
        </script>
		
</body>
</html>