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
    <title>home page</title>
</head>
<body>
    <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main">
    <?php include 'nav.php'; ?>    
    <div class="container">
                <form action="" class="d-flex gap-1 mt-5 border p-2 ">
                    <select class="form-control">
                        <option value="">Destination</option>
                        <option value="first">khouribga</option>
                        <option value="third">khoumisat</option>
                        <option value="second">casa</option>
                    </select>
                    <input type="date" class="form-control" placeholder="Date">
                    <input type="submit" value="Valider" class="btn btn-success ">
                </form>
               <div class="row mt-3">
                <div class="projects col-lg-6  mt-1 mb-1">
                    <div class="project1  d-flex justify-content-between pe-1">
                        <div class="d-flex gap-3">
                            <img src="image/hiluximg.jpg" class="img-fluid p-1 projectimg  " alt="" >
                            <div class="mt-2 desc  text-black d-flex flex-column  ">
                                <p class="title">vehicule marque</p>
                                <p class="title2">created by : service id</p>
                                <div class="prix title ">place avialble : 5 </div>
                                <form action="" class="avatar" >
                                    <input type="submit" class=" btn btn-secondary " value="Reserver" >
                                  </form>
                            </div>
                           
                        </div>
                       
                    </div>

                </div>
                <div class="projects col-lg-6 mt-1 mb-1">
                    <div class="project1  d-flex justify-content-between pe-1">
                        <div class="d-flex gap-3">
                            <img src="image/hiluximg.jpg" class="img-fluid p-1 projectimg  " alt="" >
                            <div class="mt-2 desc  text-black d-flex flex-column  ">
                                <p class="title">hillux model 2020</p>
                                <p class="title2">created by : service ttp</p>
                                <div class="prix title ">place avialble : 3 </div>
                                <form action="" class="avatar" >
                                    <input type="submit" class=" btn btn-secondary " value="Reserver" >
                                  </form>
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
