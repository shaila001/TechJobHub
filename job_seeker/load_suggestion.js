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
fetch('experience_suggestion.txt')
    .then(response => response.text())
    .then(data => {
        const suggestionsList = data.split('\n').map(item => item.trim()).filter(Boolean);

        // Access the input elements directly, since the DOM is already loaded
        const experienceInput1 = document.getElementById('experience_1');
        const experienceInput2 = document.getElementById('experience_2');
        const experienceInput3 = document.getElementById('experience_3');
        const experienceInput4 = document.getElementById('job-title');

        // Initialize the suggestions for the inputs
        loadSuggestions(experienceInput1, suggestionsList);
        loadSuggestions(experienceInput2, suggestionsList);
        loadSuggestions(experienceInput3, suggestionsList);
        loadSuggestions(experienceInput4, suggestionsList);
    })
// Fetch the suggestions from the file (you may need to adjust the path)
fetch('interest_suggestion.txt')
    .then(response => response.text())
    .then(data => {
        const suggestionsList = data.split('\n').map(item => item.trim()).filter(Boolean);

        // Access the input elements directly, since the DOM is already loaded
        const fieldOfInterestInput1 = document.getElementById('interest_1');
        const fieldOfInterestInput2 = document.getElementById('interest_2');
        const fieldOfInterestInput3 = document.getElementById('interest_3');

        // Initialize the suggestions for the inputs
        loadSuggestions(fieldOfInterestInput1, suggestionsList);
        loadSuggestions(fieldOfInterestInput2, suggestionsList);
        loadSuggestions(fieldOfInterestInput3, suggestionsList);
    })
    .catch(error => console.error('Error loading suggestions:', error));
