<?php

	include("connection.php");

	if(isset($_REQUEST['function'])){
		$function = $_REQUEST['function'];
		
		/******************************* LOGIN PAGE *******************************/
		if($function == "email_password_check"){
			$email = $_REQUEST['email'];
			$password = md5($_REQUEST['password']);
			
			$q = mysql_query("select * from user where email='$email' and password='$password'");
			$q_n = mysql_num_rows($q);
			if($q_n > 0) {
				session_start();
				$_SESSION['email'] = $email;
				echo "ok";
			}
			else {
				echo "not ok";
			}
		}
		/************************************************************************/
		
		/******************************* INDEX PAGE *******************************/
		
		elseif($function == "get_department"){
				
			$faculty_id = $_REQUEST['faculty_id'];
			$q = mysql_query("select * from department where faculty_id='$faculty_id'");
			echo "<option value = '0'>department</option>";
			while($a = mysql_fetch_array($q)){
				echo "<option value = '$a[id]'>$a[name]</option>";
			}
				
		}
		
		elseif($function == "get_group"){
		
			$department_id = $_REQUEST['department_id'];
			$course = $_REQUEST['course'];
			if($course == 0){
				$q = mysql_query("select * from `group` where department_id = '$department_id'");
			}
			else{
				$q = mysql_query("select * from `group` where department_id = '$department_id' and course = '$course'");
			}
			echo "<option value = '0'>group</option>";
			while($a = mysql_fetch_array($q)){
				echo "<option value = '$a[id]'>$a[name]</option>";
			}
		
		}
		
		elseif($function == "get_group1"){
		
			$department_id = $_REQUEST['department_id'];
			$course = $_REQUEST['course'];
			
			if($department_id != 0){
				$q = mysql_query("select * from `group` where department_id = '$department_id' and course = '$course'");
			}
			else{
				$q = mysql_query("select * from `group` where course = '$course'");
			}
			
			echo "<option value = '0'>group</option>";
			while($a = mysql_fetch_array($q)){
				echo "<option value = '$a[id]'>$a[name]</option>";
			}
		
		}
		
		elseif($function == "get_region"){
			
			$republic_id = $_REQUEST['republic_id'];
			$q = mysql_query("select * from region where republic_id='$republic_id'");
			echo "<option value = '0'>region</option>";
			while($a = mysql_fetch_array($q)){
				echo "<option value = '$a[id]'>$a[name]</option>";
			}
			
		}
		
		elseif($function == "get_city"){
				
			$region_id = $_REQUEST['region_id'];
			$q = mysql_query("select * from city where region_id='$region_id'");
			echo "<option value = '0'>city</option>";
			while($a = mysql_fetch_array($q)){
				echo "<option value = '$a[id]'>$a[name]</option>";
			}
				
		}
		
		elseif($function == "add_student"){
			
			$name_kz = $_REQUEST['name_kz'];
			$surname_kz = $_REQUEST['surname_kz'];
			$fathername_kz = $_REQUEST['fathername_kz'];
			$name_en = $_REQUEST['name_en'];
			$surname_en = $_REQUEST['surname_en'];
			$gender = $_REQUEST['gender'];
			$birthday = date('Y-d-m', strtotime($_REQUEST['birthday']));
			$email = $_REQUEST['email'];
			$phone_no = $_REQUEST['phone_no'];
			
			
			$home_republic_id = $_REQUEST['home_republic_id'];
			$home_region_id = $_REQUEST['home_region_id'];
			$home_city_id = $_REQUEST['home_city_id'];
			$home_address = $_REQUEST['home_address'];
			$home_home_no = $_REQUEST['home_home_no'];
			
			$current_republic_id = $_REQUEST['current_republic_id'];
			$current_region_id = $_REQUEST['current_region_id'];
			$current_city_id = $_REQUEST['current_city_id'];
			$current_address = $_REQUEST['current_address'];
			$current_home_no = $_REQUEST['current_home_no'];
			
			
			
			$fm_count = $_REQUEST['fm_count'];
			$fm_info = explode('|', $_REQUEST['fm_info']);
			
			
			$sdu_id = $_REQUEST['sdu_id'];
			$faculty_id = $_REQUEST['faculty_id'];
			$department_id = $_REQUEST['department_id'];
			$course = $_REQUEST['course'];
			$group_id = $_REQUEST['group_id'];
			$gpa = $_REQUEST['gpa'];
			$grant_type = $_REQUEST['grant_type'];
			$stipend = $_REQUEST['stipend'];
			
			mysql_query("insert into address (republic_id, city_id, region_id, addr, home_no) 
						values ('$home_republic_id','$home_city_id','$home_region_id','$home_address','$home_home_no')");
			
			$home_address_id = mysql_insert_id();
			
			mysql_query("insert into address (republic_id, city_id, region_id, addr, home_no)
						values ('$current_republic_id','$current_city_id','$current_region_id','$current_address','$current_home_no')");
				
			$current_address_id = mysql_insert_id();
			
			mysql_query("insert into sdu_info (sdu_id, faculty_id, department_id, course, group_id, gpa, grant_type, stipend)
						values ('$sdu_id','$faculty_id','$department_id','$course','$group_id','$gpa','$grant_type','$stipend')");
			
			$sdu_info_id = mysql_insert_id();
				
			mysql_query("insert into student (name_kz, surname_kz, fathername_kz, name_en, surname_en, 
											  gender, birthday, home_address_id, current_address_id,
											  sdu_info_id, email, phone_no)
									  values ('$name_kz','$surname_kz','$fathername_kz','$name_en','$surname_en',
									  		  '$gender','$birthday','$home_address_id','$current_address_id',
									  		  '$sdu_info_id','$email','$phone_no')");
				
			$student_id = mysql_insert_id();

			$a = 0;
			$b = 1;
			$c = 2;
			$d = 3;
			$e = 4;
			for($i = 0; $i < $fm_count; $i++){
				
				mysql_query("insert into family_member (type_of_affinity,
														name,
														surname,
														study_info,
														work_info,
														student_id)
												values ('$fm_info[$a]',
														'$fm_info[$b]',
														'$fm_info[$c]',
														'$fm_info[$d]',
														'$fm_info[$e]',
														'$student_id')");
				$a += 5;
				$b += 5;
				$c += 5;
				$d += 5;
				$e += 5;
			}
		}
		
		elseif($function == "print_student"){
			$q=mysql_query("select * from student");
			$n=mysql_num_rows($q);
			if($n > 0){
				echo "<p class='text-right'>
									<a href='javascript:edit_on_off()'><i class='fa fa-check'> enable edit command</i></a>
								</p>";
				echo "<p align='center'>
									      <button class='btn btn-info' onclick='add_student_modal()'>
										      <i class='fa fa-plus'></i> add student
										  </button>
									  </p>";
			
				$qq = mysql_query("select id,name from `group` order by name");
				while($aa = mysql_fetch_array($qq)){
						
					$q=mysql_query("select st.* from student as st, `group` as gr, sdu_info as si where st.sdu_info_id = si.id and si.group_id = gr.id and gr.id = '$aa[id]' order by st.surname_en");
					$n=mysql_num_rows($q);
					if($n>0){
						$aaa = mysql_query("select ad.name as 'adname', ad.surname as 'adsurname' from adviser as ad, adviser_group as ag where ag.group_id = '$aa[id]' and ag.adviser_id = ad.id");
						$qqq = mysql_fetch_array($aaa);
						echo "<p><span class='label label-warning' style='font-size:1.2em;'>$aa[name] - $qqq[adname] $qqq[adsurname]</span></p>";
						$i = 1;
						echo "<table class='table table-hover table-condensed table-bordered'>";
										echo "<thead>
						<tr>
						<th>#</th>
													<th>Name & Surname</th>
													<th>Gender</th>
													<th>Birthday</th>
													<th>SDU ID</th>
													<th>SDU Info</th>
													<th>Contact Info</th>
													<th>Home Address</th>
													<th>Current Address</th>
												</tr>
											</thead>
											<tbody>";
			
										while($a = mysql_fetch_array($q)){
						echo "<tr onclick='edit_adviser_modal($a[id])'>";
							echo "<td>$i</td>
							<td>$a[surname_en] $a[name_en]</td>
							<td>$a[gender]</td>";
							$birthd = date(  "F j, Y", strtotime( $a['birthday'] ) );
							echo "<td>$birthd</td>";
			
							$q1 = mysql_query("select * from sdu_info where id = '$a[sdu_info_id]'");
							$a1 = mysql_fetch_array($q1);
							echo "<td>$a1[sdu_id]</td>";
							$q2 = mysql_query("select * from faculty where id = '$a1[faculty_id]'");
							$a2 = mysql_fetch_array($q2);
							$sdu_information = "$a2[name]<br/>";
							$q2 = mysql_query("select * from department where id = '$a1[department_id]'");
							$a2 = mysql_fetch_array($q2);
							$sdu_information .= "$a2[name]<br/>";
							$q2 = mysql_query("select * from `group` where id = '$a1[group_id]'");
							$a2 = mysql_fetch_array($q2);
							$sdu_information .= "<strong>Group: </strong>$a2[name]<br/>";
							$sdu_information .= "<strong>Grant type: </strong>$a1[grant_type]<br/>";
							$sdu_information .= "<strong>Stipend: </strong>$a1[stipend]";
			
							echo "<td>$sdu_information</td>";
							echo "<td>$a[email]<br/>$a[phone_no]</td>";
			
							$q2 = mysql_query("select rep.name as 'repname', c.name as 'cname', reg.name as 'regname', ad.addr as 'addr', ad.home_no as 'homeno' from address as ad, republic as rep, city as c, region as reg where ad.id = '$a[home_address_id]' and rep.id = ad.republic_id and c.id = ad.city_id and reg.id = ad.region_id");
							$a2 = mysql_fetch_array($q2);
			
							echo "<td>$a2[repname],<br/>$a2[regname],<br/>$a2[cname],<br/>$a2[addr] $a2[homeno]</td>";
			
							$q2 = mysql_query("select rep.name as 'repname', c.name as 'cname', reg.name as 'regname', ad.addr as 'addr', ad.home_no as 'homeno' from address as ad, republic as rep, city as c, region as reg where ad.id = '$a[current_address_id]' and rep.id = ad.republic_id and c.id = ad.city_id and reg.id = ad.region_id");
							$a2 = mysql_fetch_array($q2);
			
							echo "<td>$a2[repname],<br/>$a2[regname],<br/>$a2[cname],<br/>$a2[addr] $a2[homeno]</td>";
							$i++;
						}
			
					}
					echo "</table>";
				}
			}
			else{
				if($n==0){
					echo "<p align='center' style='padding:10px;'><span class='label label-warning'>no advisers</span></p>";
				}
				echo "<p align='center'>
					<button class='btn btn-info' onclick='add_student_modal()'>
					<i class='fa fa-plus'></i> add student
					</button>
				</p>";
			}
		}
		
		elseif ($function == "search"){
			
			$name = $_REQUEST['search_name'];
			$surname = $_REQUEST['search_surname'];
			$gender = $_REQUEST['search_gender'];
			
			$address_type = $_REQUEST['search_address_type'];
			$republic = $_REQUEST['search_republic'];
			$region = $_REQUEST['search_region'];
			$city = $_REQUEST['search_city'];
			
			$sdu_id = $_REQUEST['search_sdu_id'];
			$faculty = $_REQUEST['search_faculty'];
			$department = $_REQUEST['search_department'];
			$course = $_REQUEST['search_course'];
			$group = $_REQUEST['search_group'];
			$grant_type = $_REQUEST['search_grant_type'];
			$stipend = $_REQUEST['search_stipend'];
			$min_gpa = $_REQUEST['search_min_gpa'];
			$max_gpa = $_REQUEST['search_max_gpa'];
			
			echo "$sdu_id | $faculty | $department | $course | $group | $grant_type | $stipend | $min_gpa | $max_gpa";
			echo "<br/>$republic | $region | $city";
			echo "<br/>$name | $surname | $gender";
			$family_members_count = $_REQUEST['search_family_member_count'];
			
			$isNothing = false;
			
			if(
					($sdu_id == "" &&
					 $faculty == 0 &&
					 $department == 0 &&
					 $course == 0 &&
					 $group == 0 &&
					 $grant_type == "" &&
					 $stipend == "" &&
					 $min_gpa == 0 &&
					 $max_gpa == 4) &&
					($republic == 0 &&
					 $region == 0 &&
					 $city == 0) &&
					($name == "" && 
					 $surname == "" && 
					 $gender == "")) {

				$isNothing = true;
						
			}
			
			else if(
					($sdu_id == "" && 
					 $faculty == 0 && 
					 $department == 0 && 
					 $course == 0 && 
					 $group == 0 && 
					 $grant_type == "" && 
					 $stipend == "" && 
					 $min_gpa == 0 &&
					 $max_gpa == 4) && 
					($republic == 0 && 
					 $region == 0 && 
					 $city == 0)){
				echo "a";
				$query = "select * from student where ";
				
				if($name != ""){
					$query .= " name_en like '%$name%' ";
				}
				
				if ($surname != ""){
					if($query != "select * from student where "){
						$query .= " and ";
					}
					$query .= " surname_en like '%$surname%' ";
				}
				
				if ($gender != ""){
					if($query != "select * from student where "){
						$query .= " and ";
					}
					$query .= " gender = '$gender' ";
				}
			}
			
			elseif(
					($name == "" && 
					 $surname == "" && 
					 $gender == "") && 
					($republic == 0 && 
					 $region == 0 && 
					 $city == 0)){
				echo "b";
				if($course == 0){
					$query = "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa ";
				}
				else{
					$query = "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa ";
				}
				
				if($sdu_id != ""){
					$query .= " and si.sdu_id like '%$sdu_id%' ";
				}
				
				if($faculty != 0){
					if($query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa " || $query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa "){
						$query .= " and ";
					}
					$query .= " si.faculty_id = '$faculty' ";
				}
				
				if($department != 0){
					if($query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa " || $query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa "){
						$query .= " and ";
					}
					$query .= " si.department_id = '$department' ";
				}
				
				if($group != 0){
					if($query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa " || $query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa "){
						$query .= " and ";
					}
					$query .= " si.group_id = '$group' ";
				}
				
				if($grant_type != ""){
					if($query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa " || $query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa "){
						$query .= " and ";
					}
					$query .= " si.grant_type = '$grant_type' ";
				}
				
				if($stipend != ""){
					if($query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and gpa between $min_gpa and $max_gpa " || $query != "select st.* from student as st, sdu_info as si where st.sdu_info_id = si.id and course = '$course' and gpa between $min_gpa and $max_gpa "){
						$query .= " and ";
					}
					$query .= " si.stipend = '$stipend' ";
				}

			}
			
			elseif(
					($name == "" && 
					 $surname == "" && 
					 $gender == "") && 
					($sdu_id == "" && 
					 $faculty == 0 && 
					 $department == 0 && 
					 $course == 0 && 
					 $group == 0 &&
					 $grant_type == "" && 
					 $stipend == "" && 
					 $min_gpa == 0 &&
					 $max_gpa == 4)){
				echo "c";
				if($address_type == "home"){
					$query = "select st.* from student as st, address as ad where st.home_address_id = ad.id and ";
				}
				else{
					$query = "select st.* from student as st, address as ad where st.current_address_id = ad.id and ";
				}
				
				if($republic != 0){
					$query .= " ad.republic_id = '$republic' ";
				}
				
				if($region != 0){
					if($query != "select st.* from student as st, address as ad where st.home_address_id = ad.id and " || $query != "select st.* from student as st, address as ad where st.current_address_id = ad.id and "){
						$query .= " and ";
					}
					$query .= " ad.region_id = '$region' ";
				}
				
				if($city != 0){
					if($query != "select st.* from student as st, address as ad where st.home_address_id = ad.id and " || $query != "select st.* from student as st, address as ad where st.current_address_id = ad.id and "){
						$query .= " and ";
					}
					$query .= " ad.city_id = '$city' ";
				}
			}
			
			elseif(
					($sdu_id != "" || 
					 $faculty != 0 || 
					 $department != 0 || 
					 $course != 0 || 
					 $group != 0 ||
					 $grant_type != "" ||
					 $stipend != "" || 
					 $min_gpa != 0 ||
					 $max_gpa != 4) || 
					($name != "" || $surname != "" || $gender != "") || 
					($republic != 0 || $region != 0 || $city != 0)){
				echo "d";
				if($address_type == "home"){
					$query = "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa ";
				}
				else{
					$query = "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa ";
				}
				
				if($course != 0){
					$query .= " and si.course = '$course' ";
				}
				
				if($name != ""){
					$query .= " and st.name_en like '%$name%' ";
				}
				
				if ($surname != ""){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " st.surname_en like '%$surname%' ";
				}
				
				if ($gender != ""){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " gender = '$gender' ";
				}
				
				if($sdu_id != ""){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and and si.gpa between $min_gpa and $max_gpa si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.sdu_id like '%$sdu_id%' ";
				}
				
				if($faculty != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.faculty_id = '$faculty' ";
				}
				
				if($department != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.department_id = '$department' ";
				}
				
				if($group != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.group_id = '$group' ";
				}
				
				if($grant_type != ""){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.grant_type = '$grant_type' ";
				}
				
				if($stipend != ""){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " si.stipend = '$stipend' ";
				}
				
				if($republic != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " ad.republic_id = '$republic' ";
				}
				
				if($region != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " ad.region_id = '$region' ";
				}
				
				if($city != 0){
					if($query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " || 
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.home_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' " ||
					   $query != "select distinct st.id, st.* from student as st, address as ad, sdu_info as si where st.current_address_id = ad.id and si.gpa between $min_gpa and $max_gpa and si.course = '$course' "){
						$query .= " and ";
					}
					$query .= " ad.city_id = '$city' ";
				}
			}
			
			
			if($isNothing == false){
				$q = mysql_query($query);
				echo $query;
				
				$q_n = mysql_num_rows($q);
				
				if($q_n > 0){
					echo "<table class='table table-hover table-condensed table-bordered'>";
					echo "<thead>
											<tr>
												<th>#</th>
												<th>Name & Surname</th>
												<th>Gender</th>
												<th>Birthday</th>
												<th>SDU ID</th>
												<th>SDU Info</th>
												<th>Contact Info</th>
												<th>Home Address</th>
												<th>Current Address</th>
											</tr>
										</thead>
										<tbody>";
					$i = 1;
					while($a = mysql_fetch_array($q)){
						echo "<tr>";
						echo "<td>$i</td>
						<td>$a[name_en] $a[surname_en]</td>
						<td>$a[gender]</td>";
						$birthd = date(  "F j, Y", strtotime( $a['birthday'] ) );
						echo "<td>$birthd</td>";
						
						$q1 = mysql_query("select * from sdu_info where id = '$a[sdu_info_id]'");
						$a1 = mysql_fetch_array($q1);
						echo "<td>$a1[sdu_id]</td>";
						$q2 = mysql_query("select * from faculty where id = '$a1[faculty_id]'");
						$a2 = mysql_fetch_array($q2);
						$sdu_information = "$a2[name]<br/>";
						$q2 = mysql_query("select * from department where id = '$a1[department_id]'");
						$a2 = mysql_fetch_array($q2);
						$sdu_information .= "$a2[name]<br/>";
						$q2 = mysql_query("select * from `group` where id = '$a1[group_id]'");
						$a2 = mysql_fetch_array($q2);
						$sdu_information .= "<strong>Group: </strong>$a2[name]<br/>";
						$sdu_information .= "<strong>Grant type: </strong>$a1[grant_type]<br/>";
						$sdu_information .= "<strong>Stipend: </strong>$a1[stipend]";
						
						echo "<td>$sdu_information</td>";
						echo "<td>$a[email]<br/>$a[phone_no]</td>";
						
						$q2 = mysql_query("select rep.name as 'repname', c.name as 'cname', reg.name as 'regname', ad.addr as 'addr', ad.home_no as 'homeno' from address as ad, republic as rep, city as c, region as reg where ad.id = '$a[home_address_id]' and rep.id = ad.republic_id and c.id = ad.city_id and reg.id = ad.region_id");
						$a2 = mysql_fetch_array($q2);
						
						echo "<td>$a2[repname],<br/>$a2[regname],<br/>$a2[cname],<br/>$a2[addr] $a2[homeno]</td>";
						
						$q2 = mysql_query("select rep.name as 'repname', c.name as 'cname', reg.name as 'regname', ad.addr as 'addr', ad.home_no as 'homeno' from address as ad, republic as rep, city as c, region as reg where ad.id = '$a[current_address_id]' and rep.id = ad.republic_id and c.id = ad.city_id and reg.id = ad.region_id");
						$a2 = mysql_fetch_array($q2);
							
						echo "<td>$a2[repname],<br/>$a2[regname],<br/>$a2[cname],<br/>$a2[addr] $a2[homeno]</td>";
						$i++;
					}
				}
			}
			else{
				echo "no data found | php";
			}
		}
		/************************************************************************/
		
		/******************************* ADMIN PAGE *******************************/
		
		elseif($function == "add_adviser"){
		
			$name = $_REQUEST['name'];
			$surname = $_REQUEST['surname'];
			$adviser_sdu_id = $_REQUEST['adviser_sdu_id'];
			$phone_no = $_REQUEST['phone_no'];
			$email = $_REQUEST['email'];
			$groups = $_REQUEST['groups'];
			
			$arr = explode('|', $groups);
			
			
			$password = md5('aaa');
			
			$r = mysql_query("insert into user (email, password) values ('$email', '$password')");
			if($r){
				$user_id = mysql_insert_id();
				$r = mysql_query("insert into adviser (name, surname, sdu_id, email, phone_no, user_id) values('$name', '$surname', '$adviser_sdu_id', '$email', '$phone_no', '$user_id'); ");
				if($r){
					$adviser_id = mysql_insert_id();
					for($i = 0; $i < sizeof($arr); $i++){
						mysql_query("insert into adviser_group (adviser_id, group_id) values('$adviser_id', '$arr[$i]')");
					}
					echo "ok";
				}
			}
		}
		
		elseif($function == "edit_adviser"){
			
			$id = $_REQUEST['adviser_id'];
			$name = $_REQUEST['name'];
			$surname = $_REQUEST['surname'];
			$adviser_sdu_id = $_REQUEST['adviser_sdu_id'];
			$phone_no = $_REQUEST['phone_no'];
			$email = $_REQUEST['email'];
			$groups = $_REQUEST['groups'];
				
			$arr = explode('|', $groups);
				
			mysql_query("update adviser set name = '$name', 
												 surname = '$surname', 
												 sdu_id = '$adviser_sdu_id', 
												 email = '$email', 
												 phone_no = '$phone_no' where id = '$id' ");
			
			$q = mysql_query("select user_id from adviser where id = '$id' ");
			$a = mysql_fetch_array($q);
			$user_id = $a['user_id'];
			
			mysql_query("update user set email = '$email' where id = '$user_id' ");
			
			mysql_query("delete from adviser_group where adviser_id = '$id'");
			
			for($i = 0; $i < sizeof($arr); $i++){
				mysql_query("insert into adviser_group (adviser_id, group_id) values('$id', '$arr[$i]')");
			}
			
			echo "ok";
		}
		
		elseif($function == "get_adviser"){
			$adviser_id = $_REQUEST['adviser_id'];
			$q = mysql_query("select * from adviser where id = '$adviser_id'");
			$a = mysql_fetch_array($q);
			$res = "$a[name]|$a[surname]|$a[sdu_id]|$a[email]|$a[phone_no]|";
			$q = mysql_query("select gr.id as 'grid', gr.name as 'grname' from `group` as gr, adviser_group as ag where ag.adviser_id = '$adviser_id' and ag.group_id = gr.id");
			while($a = mysql_fetch_array($q)){
				$res .= $a['grid']."|";
				$res .= $a['grname']."|";
			}
			echo $res;
			
		}
		
		elseif($function == "remove_adviser"){
			$adviser_id = $_REQUEST['adviser_id'];
			$q = mysql_query("select user_id from adviser where id = '$adviser_id' ");
			$arr = mysql_fetch_array($q);
			$a = mysql_query("delete from user where id = '$arr[user_id]'");
			$b = mysql_query("delete from adviser_group where adviser_id = '$adviser_id'");
			$c = mysql_query("delete from adviser where id = '$adviser_id'");
			if($a && $b && $c){
				echo "ok";
			}
		}
		
		elseif ($function == "print_adviser"){
			$q=mysql_query("select * from adviser");
			$n=mysql_num_rows($q);
			
			if($n > 0){
				echo "<p class='text-right'>
									<a href='javascript:edit_on_off()'><i class='fa fa-check'> enable edit command</i></a>
								</p>";
				echo "<table class='table table-hover table-condensed table-bordered'>";
				echo "<thead>
										<tr>
											<th>#</th>
											<th>Name & Surname</th>
											<th>SDU ID</th>
											<th>Email</th>
											<th>Phone no</th>
											<th>Group(s)</th>
										</tr>
									</thead>
									<tbody>";
				$i = 1;
				while($a = mysql_fetch_array($q)){
					echo "<tr onclick='edit_adviser_modal($a[id])'>";
					echo "<td>$i</td>
					<td>$a[name] $a[surname]</td>
					<td>$a[sdu_id]</td>
					<td>$a[email]</td>
					<td>$a[phone_no]</td>";
					$q1 = mysql_query("select gr.* from adviser_group as ag, `group` as gr where ag.adviser_id = '$a[id]' and ag.group_id = gr.id");
					$str = "";
					while($a1 = mysql_fetch_array($q1)){
						$str .= "<p>$a1[name]</p>";
					}
					echo "<td>$str</td>";
					echo "</tr>";
					$i++;
				}
				echo "</table>";
				echo "<p align='center'>
						<button class='btn btn-info' onclick='add_adviser_modal()'>
						    <i class='fa fa-plus'></i> add adviser
						  </button>
						 </p>";
				
			}
			else{
				if($n==0){
					echo "<p align='center' style='padding:10px;'><span class='label label-warning'>no advisers</span></p>";
				}
				echo "<p align='center'>
				        <button class='btn btn-info' onclick='add_adviser_modal()'>
				    	    <i class='fa fa-plus'></i> add adviser
						 </button>
					 </p>";
			}
		}
	}

?>