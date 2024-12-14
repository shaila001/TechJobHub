document.addEventListener('DOMContentLoaded', function () {
    
    // const enterButton = document.querySelector('.enter-button');
    // enterButton.addEventListener('click', function () {
    //     window.location.href = 'job-listings.html'; // Redirect to a job listings page
    // });

    const categories = document.querySelectorAll('.category');
    
    categories.forEach(function (category) {
        category.addEventListener('mouseenter', function () {
            category.style.transform = 'scale(1.05)';
            category.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
        
        category.addEventListener('mouseleave', function () {
            category.style.transform = 'scale(1)';
            category.style.boxShadow = 'none';
        });
    });

    
    const notificationIcon = document.querySelector('.notification-icon');
    notificationIcon.addEventListener('click', function () {
        alert('You have no new notifications!');
    });

    const profileIcon = document.querySelector('.profile-icon');
    profileIcon.addEventListener('click', function () {
        window.location.href = "/profile'"; 
    });

    

    const menuIcon = document.querySelector('.menu-icon');
    menuIcon.addEventListener('click', function () {
        // alert('Menu button clicked! Implement your menu logic here.');
    });
});

  // Get elements
  const searchIcon = document.getElementById("search-icon");
  const searchBarContainer = document.getElementById(
    "search-bar-container"
  );
  const closeBtn = document.getElementById("close-btn");

  // When the search icon is clicked, show the search bar
  searchIcon.addEventListener("click", function () {
    // Toggle active class to animate the search bar
    searchBarContainer.classList.toggle("active");

    // Set the search bar to visible when active
    if (searchBarContainer.classList.contains("active")) {
      searchBarContainer.style.display = "flex"; // Ensure the bar is visible
    }
  });

  // When the close button is clicked, hide the search bar
  closeBtn.addEventListener("click", function () {
    // Hide the search bar and collapse it back
    searchBarContainer.classList.remove("active");
    searchBarContainer.style.display = "none"; // Hide it again after the animation
  });
