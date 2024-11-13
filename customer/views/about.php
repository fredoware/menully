
    <h1>About Page</h1>
    <p>This is the about page of the AngularJS application.</p>
    
    <!-- Form for submitting data -->
    <form ng-submit="submitForm()">
        <label for="title">Title:</label>
        <input type="text" id="title" ng-model="formData.title" required>
        
        <label for="body">Body:</label>
        <textarea id="body" ng-model="formData.body" required></textarea>
        
        <button type="submit">Submit</button>
    </form>

    <p>{{ message }}</p> <!-- Display message after form submission -->
    <a href="example">Go to Example Page</a> <!-- Link back to Example page -->
