<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function(){
        $("#hidebutton").click(function(){
            $("table").hide();
        });
        $("#showbutton").click(function(){
            $("table").show();
        });
    });

   
    </script>
</head>
<body>
    <div class="main">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand icon" href="main.php">
                    <h2 class="logo text-shadow">XPLORE</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="main.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#destinations">Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#news">Tours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="login.php">Login</a>
                        </li>
                        <li class="nav-item"></li>
                            <a class="nav-link" aria-current="page" href="blog.php">Blog</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#news">About Us</a></li>
                                <li><a class="dropdown-item" href="#contactform">Contact Us</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2 srch" type="search" placeholder="Search destinations" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
        </nav>

        <div class="hero">
            <video class="hero-video" autoplay muted loop>
                <source src="vid.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <h1 class="hero-title">Explore Japan</h1>
            <p class="hero-subtitle">Find your next adventure</p>
            <a href="#destinations" class="hero-btn">Discover</a>
        </div>

        

        <div class="section">
            
            <div class="text-section">
                <p><b><h1>LAND OF THE RISING SUN</h1></b></p>
              <p id="#01"> Japan, often called "The Land of the Rising Sun," is known for its blend of ancient traditions and modern innovation. The name reflects its position east of the Asian continent, where the sun rises first. With its serene temples, bustling cities like Tokyo, stunning landscapes, and cultural richness, Japan offers a unique mix of historical and contemporary experiences, from tranquil cherry blossoms to cutting-edge technology.
              </p>
            </div>
            <h2 class="section-title">Top Travel Destinations in Japan</h2>

            <div class="container my-4">
            <div class="image-section">
            <img src="japan.png"></image>
            <div class="pin shibuya">
            <a href="destinations.html?tile=1"><span>Shibuya</span></a>
            </div>
            <div class="pin kyoto">
                <a href="destinations.html?tile=2"><span>Kyoto</span></a>
                </div>
                <div class="pin osaka">
                    <a href="destinations.html?tile=3"><span>Osaka</span></a>
                </div>
                <div class="pin hiroshima">
                    <a href="destinations.html?tile=4"><span>Hiroshima</span></a>
                </div>
                <div class="pin sapparo">
                    <a href="destinations.html?tile=5"><span>Sapparo</span></a>
                </div>
                
            <br><br><br>
            </div>
            </div>
           
            


            <table class="table">
                <table class="table">
                    <tr>
                      <th>City</th>
                      <th>Attraction</th>
                      <th>Description</th>
                    </tr>
                    <tbody id="destination-data"></tbody>
                  </table>
                  <br><br>
            <button id="hidebutton">Hide</button>
            <button id="showbutton">Show</button>

        </div>
        <script>
            $(document).ready(function () {
    $("#hidebutton").click(function () {
      $("table").hide();
    });
    $("#showbutton").click(function () {
      $("table").show();
    });
  
    // Load JSON data
    fetch('main.json')
    .then(response => response.json())
    .then(data => {
      const destinationData = document.getElementById('destination-data');
  
      // Populate table with data
      data[1].destinations.forEach(destination => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${destination.city}</td>
          <td>${destination.attraction}</td>
          <td>${destination.description}</td>
        `;
        destinationData.appendChild(row);
      });
    });
  });
        </script>
       

       <div class="section">
        <h2 class="section-title text-center">Destinations</h2>
        <div class="container" id="destinations">
          <div class="row">
            </div>
        </div>
      </div>

      <script>
        $(document).ready(function() {
          // Load JSON data
          fetch('destinations.json')
            .then(response => response.json())
            .then(data => {
              const destinationsContainer = document.getElementById('destinations');
        
              let tilesPerRow = 2; // Number of tiles per row (adjusted to 2)
              let currentRow = document.createElement('div');
              currentRow.classList.add('row');
        
              // Iterate over each destination object
              data.forEach((destination, index) => {
                const destinationItem = document.createElement('div');
                destinationItem.classList.add('col-md-6', 'col-sm-6', 'col-12', 'mb-4');
        
                const galleryItem = document.createElement('div');
                galleryItem.classList.add('gallery-item');
        
                const link = document.createElement('a');
                link.href = `destinations.html?tile=${destination.id}`; // Assuming you have "id" in JSON
        
                const image = document.createElement('img');
                image.src = destination.image;
                image.classList.add('img-fluid');
                image.alt = destination.title;
        
                const overlay = document.createElement('div');
                overlay.classList.add('overlay');
        
                const title = document.createElement('h3');
                title.textContent = destination.title;
        
                overlay.appendChild(title);
                link.appendChild(image);
                link.appendChild(overlay);
                galleryItem.appendChild(link);
                destinationItem.appendChild(galleryItem);
        
                // Add the destination item to the current row
                currentRow.appendChild(destinationItem);
        
                // Check if it's time to create a new row
                if ((index + 1) % tilesPerRow === 0 || index === data.length - 1) {
                  // Append the completed row to the container
                  destinationsContainer.appendChild(currentRow);
                  // Create a new row for the next items
                  currentRow = document.createElement('div');
                  currentRow.classList.add('row');
                }
              });
            });
        });
        </script>



        
        <div class="section" id="news">
            <h2 class="section-title">Latest News</h2>
            <div class="news-grid">
                <div class="news-item">
                    <img src="fuji.jpg" alt="News Image 1" class="news-image">
                    <p class="news-text">Discover the top hidden travel gems in Japan for 2024.</p>
                </div>
                <div class="news-item">
                    <img src="cherry blossom.jpeg" alt="News Image 2" class="news-image">
                    <p class="news-text">Explore Japan's cherry blossom season highlights and best viewing spots.</p>
                </div>
                <div class="news-item">
                    <img src="hot springs.jpeg" alt="News Image 3" class="news-image">
                    <p class="news-text">Guide to Japan's most picturesque onsen (hot springs) for relaxation and rejuvenation.</p>
                </div>
            </div>

            
            
        </div>
        
        <div class="contact-form" id="contactform">
            <h2>Contact Us</h2>
            <form action="#" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                
                <button type="submit" class="btn">Send</button>
            </form>
        </div>

        <footer>
            <p>By using our Website, you agree to abide by our terms and conditions. For more details, please review our full Terms and Conditions.</p>
            <p>&copy; 2024 Plane Showcase. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>







