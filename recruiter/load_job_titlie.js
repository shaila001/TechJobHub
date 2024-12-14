// Function to fetch suggestions from the txt file and filter them based on input
function loadSuggestions(inputElement, suggestionsList) {
    inputElement.addEventListener('input', function() {
        const query = inputElement.value.toLowerCase();
        const filteredSuggestions = suggestionsList.filter(item => item.toLowerCase().includes(query));
        displaySuggestions(inputElement, filteredSuggestions);
    });
}

// Display filtered suggestions
function displaySuggestions(inputElement, suggestions) {
    let dataList = document.getElementById(inputElement.id + '-datalist');
    if (!dataList) {
        dataList = document.createElement('datalist');
        dataList.id = inputElement.id + '-datalist';
        inputElement.setAttribute('list', dataList.id);
        inputElement.parentNode.appendChild(dataList);
    }
    dataList.innerHTML = ''; // Clear previous suggestions

    suggestions.forEach(function(suggestion) {
        const option = document.createElement('option');
        option.value = suggestion;
        dataList.appendChild(option);
    });
}

// Fetch the suggestions from the file (you may need to adjust the path)
fetch('job_title_suggestion.txt')
    .then(response => response.text())
    .then(data => {
        const suggestionsList = data.split('\n').map(item => item.trim()).filter(Boolean);

        // Access the input elements directly, since the DOM is already loaded
        const experienceInput4 = document.getElementById('job-title');

        // Initialize the suggestions for the inputs
        loadSuggestions(experienceInput4, suggestionsList);
    })
// Fetch the suggestions from the file (you may need to adjust the path)
    .catch(error => console.error('Error loading suggestions:', error));
