<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/boss-dash.css">
    <title>home page</title>
</head>
<body>
    <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main">
    <?php include 'nav.php'; ?>    
    <div class="container-fluid mt-5  p-5">
        <div class="row ">
            <div class="col-lg-5 mb-5 profile1 text-center">
                <div class="cart ">
                    <div class="cart-body d-flex flex-column">
                        <img src="image/avatar.PNG" alt="" class="img-fluid  mt-3   mb-5">
                        <div class="d-flex justify-content-between text-black">
                            <h5>My profile</h5>
                            <h6 class="w-50 text-black-50 ">  if you want to change any information :   </h6>
                        </div>
                        <form class="mt-4 d-flex flex-column" action="">
                            <div class="d-flex justify-content-between gap-4">
                                <input type="text" placeholder="Oussama lakrafi" class="form-control  ">
                                <input type="text" placeholder="06666666" class="form-control ">
                            </div>
                            <input type="email" class="form-control mt-2 " placeholder="oussama@gmail.com">
                            <input type="submit" value="confirmer" class="btn btn-primary mt-3 w-50" name="save" id="">
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-6 d-flex flex-column text-center   profile1">
                <div class="h-50 mt-4 "> 
                    <form class="d-flex flex-column gap-3 text-black" action="">
                        <label class="mb-3 mt-5 text-black-50" for="">change passowrd</label>
                        <input type="password" class="form-control" placeholder="old password">
                        <input type="password" class="form-control" placeholder="new password">
                        <input type="password" class="form-control" placeholder="confirm password">
                        <input type="submit" class="btn btn-primary mb-5" value="confirmer">
                    </form>
                </div>
                <div class="h-50  mb-4">
                    <form action="" class=" d-flex flex-column gap-4  mb-5">
                        <label class=" text-black-50" for="">change avatar : </label>
                        <input type="file" name="" accept="image/*" class="form-control" multiple>
                        <input type="submit" class="btn btn-primary mb-4 " value="modifer"  name="" id="">
                    </form>
                    
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" card crudtab">
                            <div class="card-header">
                                <h4 class="mt-2 text-black">my reservation  : 
                                
                                    
                                </h4>
                            </div>
                            <div class="card-body   ">

                                <table class="table table-bordered  text-center   custom-table">
                                    <thead>
                                        <tr>
                                            <th>distination</th>
                                            <th>date</th>
                                            <th>heure</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td> 
                                                        <td></td> 
                                                        <td class="d-flex gap-2">
                                                            <div >
                                                            <a href="" class=" mb-2 btn btn-info btn-sm">View-details</a>
                                                            </div>
                                                            <div class="">
                                                            
                                                            <form action="" method="POST" class="d-inline">
                                                            <button type="submit" name="delete_student" value="student_id" class="btn btn-danger btn-sm mb-2">annuler</button> 
                                                            </form>
                                                        
                                                            </div>
                                                        </td>
                                                    </tr>
                                                
                                        
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> 
    </div>
    </div>
    <?php include 'footer.php'; ?>    
  
   
</body>
</html>
