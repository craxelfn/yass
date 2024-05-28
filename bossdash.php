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
    <link rel="stylesheet" href="styles/project.css">
    <link rel="stylesheet" href="styles/boss-dash.css">
    <title>home page</title>
</head>
<body>
    <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main">
    <?php include 'nav.php'; ?>    
    <div class="container   mt-5  mb-5">
                    <div class="row ">
                        <div class="col-lg-4">
                            <div class="card text-uppercase numproj mb-3">
                                <div class="card-body">
                                    <h4>car number :  </h4>
                                    <h1 class="text-center mt-3 text-black-50">00</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card text-uppercase profit mb-3">
                                <div class="card-body">
                                    <h4>car dispo </h4>
                                    <h1 class="text-center mt-3 text-black-50">0</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-uppercase proj-num mb-4">
                            <div class="card numproj">
                                <div class="card-body">
                                    <h4>mission num </h4>
                                    <h1 class="text-center mt-3 text-black-50">00</h1>
                                </div>
                            </div>
                        </div>
                       
                        
                        
                        
                        
                    </div>
                    
                </div>



                <div class="container mb-5 mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card  ">
                                <div class="card-header  d-flex justify-content-between ">
                                    <h4 class="text-black">missions details
                                    </h4>
                                    <div class=" float-end  ">
                                        <button class="btn  btn-primary ">add-mission</button>
                                       </div>
                                </div>
                                <div class="card-body  ">
            
                                    <table class="table table-bordered  text-center    custom-table">
                                        <thead>
                                            <tr>
                                                <th>conducteur</th>
                                                <th>voiture</th>
                                                <th>seat-availble</th>
                                                <th>date</th>
                                                <th>time</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                       
                                                    
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class=" d-flex gap-2">
                                                    <div >
                                                    <a href="" class=" mb-2 btn btn-info btn-sm">View</a>
                                                    
                                                     </div>
                                                     <div class="">
                                                    <form action="" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_student" value="student_id" class="btn btn-danger btn-sm mb-2">supp</button> 
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
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card crudtab">
                                <div class="card-header">
                                    <h4 class="text-black">cars details
                                       
                                        <select class="form-select float-end" aria-label="Default select example">
                                            <option selected>ALL</option>
                                            <option value="1">hilux</option>
                                            <option value="2">dacia</option>
                                            <option value="3">logan</option>
                                            <option value="4">hilux</option>
                                          </select>
                                          <button class="btn  btn-primary float-end ">add-car</button>
                                    </h4>
                                </div>
                                <div class="card-body  ">
            
                                    <table class="table table-bordered  text-center    custom-table">
                                        <thead>
                                            <tr>
                                                <th>image</th>
                                                <th>marque</th>
                                                <th>matricule</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                        <tr>
                                                            <td><img src="image/hiluximg.jpg" class="img-fluid" alt=""></td>
                                                            <td></td>
                                                            
                                                            <td></td>
                                                            <td class=" d-flex gap-2">
                                                                <div >
                                
                                                                <form action="" method="POST" class=" d-inline">
                                                                <button type="submit" name="delete_student" value="student_id" class="btn btn-danger  mb-2">Delete</button> 
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
    <?php include 'footer.php'; ?>    
  
   
</body>
</html>
