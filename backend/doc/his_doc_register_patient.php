<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient']))
		{
            $pat_number = $_POST['pat_number'];
           
            $pat_ailment = $_POST['pat_ailment'];
            $prescription = $_POST['pat_pres'];
            
            $pat_date= $_POST['pat_date'];
           


            $query1 = "SELECT * FROM his_patients WHERE roll_no=?";

            $stmt1= $mysqli->prepare($query1);

            $stmt1->bind_param('s',$pat_number);

            $stmt1->execute();

            $result= $stmt1->get_result();

            while($row = $result->fetch_assoc())
            {
                $pat_phone=$row['pat_phone'];
                $pat_addr=$row['pat_addr'];
                $pat_fname=$row['pat_fname'];
                $pat_lname=$row['pat_lname'];
            }

            $stmt1->close();


			$query="insert into his_record (fname,ailment,lname,roll_no,appointment_date,prescription) values(?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssss', $pat_fname, $pat_ailment, $pat_lname, $pat_number, $pat_date,$prescription);
			$stmt->execute();



			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Details Added";
              
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">Add Patient</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Patient Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <!-- <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">First Name</label>
                                                    <input type="text" required="required" name="pat_fname" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Last Name</label>
                                                    <input required="required" type="text" name="pat_lname" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div> -->
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Date</label>
                                                    <input type="text" required="required" name="pat_date" class="form-control" id="inputEmail4" placeholder="YYYY-MM-DD">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Patient Number</label>
                                                    <input required="required" type="text" name="pat_number" class="form-control"  id="inputPassword4" placeholder="Patient's Number">
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="inputAddress" class="col-form-label">Date</label>
                                                <input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress" placeholder="Patient's Addresss">
                                            </div> -->

                                            <!-- <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Date</label>
                                                    <input required="required" type="text" name="pat_phone" class="form-control" id="inputCity">
                                                </div> -->
                                         
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Patient Ailment</label>
                                                    <input required="required" type="text" name="pat_ailment" class="form-control" id="inputCity">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Prescription</label>
                                                    <input required="required" type="text" name="pat_pres" class="form-control" id="inputpres">
                                                </div>

                                              
                                            </div>

                                            <button type="submit" name="add_patient" class="ladda-button btn btn-primary" data-style="expand-right">Add Patient</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                    <!-- <div>Hello</div> -->
                    <?php 
                    
                    $query5 = "SELECT pat_phone, pat_addr, GROUP_CONCAT(pat_fname) as pat_fname, GROUP_CONCAT(pat_lname) as pat_lname
                    FROM his_patients WHERE roll_no=? GROUP BY pat_phone, pat_addr";
         $stmt1 = $mysqli->prepare($query5);
         $stmt1->bind_param('s', $pat_number);
         $stmt1->execute();
         $result = $stmt1->get_result();
         
         // Check if any rows were returned
         if ($result->num_rows > 0) {
            echo '<div style="width: 400px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">';
        
            while ($row = $result->fetch_assoc()) {
                $firstNames = explode(',', $row['pat_fname']);
                $lastNames = explode(',', $row['pat_lname']);
        
                echo '<div style="margin-bottom: 15px;">';
                echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Phone:</label>';
                echo '<div style="border: 1px solid #ddd; padding: 8px; border-radius: 4px;">' . $row['pat_phone'] . '</div>';
                echo '</div>';
        
                echo '<div style="margin-bottom: 15px;">';
                echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Address:</label>';
                echo '<div style="border: 1px solid #ddd; padding: 8px; border-radius: 4px;">' . $row['pat_addr'] . '</div>';
                echo '</div>';
        
                echo '<div style="margin-bottom: 15px;">';
                echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">First Name:</label>';
                echo '<div style="border: 1px solid #ddd; padding: 8px; border-radius: 4px;">' . implode(', ', array_unique($firstNames)) . '</div>';
                echo '</div>';
        
                echo '<div style="margin-bottom: 15px;">';
                echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Last Name:</label>';
                echo '<div style="border: 1px solid #ddd; padding: 8px; border-radius: 4px;">' . implode(', ', array_unique($lastNames)) . '</div>';
                echo '</div>';
            }
        
            echo '</div>';
        } else {
            echo 'No results found.';
        }
         
         $stmt1->close();
         $mysqli->close();
         

            // $stmt1->close();
                    ?>

                </div> <!-- content -->

                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>