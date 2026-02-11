// js/app.js

// Function for searching licenses
async function searchLicenses(query) {
    try {
        const response = await fetch(`https://api.example.com/licenses?search=${query}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// Function to handle API responses
function handleApiResponse(data) {
    if (data && data.licenses) {
        data.licenses.forEach(license => {
            console.log(`License Name: ${license.name}, ID: ${license.id}`);
        });
    } else {
        console.log('No licenses found.');
    }
}