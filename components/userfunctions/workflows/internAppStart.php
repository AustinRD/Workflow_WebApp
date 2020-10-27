<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<script>
    //Hides the currently hardcoded Feed from workflows.php
    document.getElementById('activityFeed').style.display = 'none';
</script>

<!-- Start Workflow -->
<div class="w3-card-4 w3-margin w3-padding">
    <h5>Student Internship/Fieldwork Application</h5>
    <form method="post">
        <label for="firstName">First name</label>
        <input type="text" class="w3-input" name="firstname" id="firstname" placeholder="Enter the Student's First Name." required>
        <label for="lastName">Last name</label>
        <input type="text" class="w3-input" name="lastname" id="lastName" placeholder="Enter the Student's Last Name." required>
        <label for="lastName">Middle Initial</label>
        <input type="text" class="w3-input" name="middlename" id="middlename" maxlength="1" placeholder="Enter the Student's Middle Initial.">
        <label for="address">Local Address: <br>Street</label>
        <input type="text" class="w3-input" name="address" id="address" placeholder="Enter the Student's street address." required>
        <label for="address2">Apt. No. </label>
        <input type="text" class="w3-input" name="aptnumber" id="address2" placeholder="Enter the Apartment or suite">
        <label for="zip">City</label>
        <input type="text" class="w3-input" name="city" id="zip" placeholder="Enter the Student's City." required>
        <label for="state">State</label>
        <select class="w3-input" name="state" id="state" required>
            <option value="">Select the Student's State.</option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
        </select>
        <label for="zip">Zip</label>
        <input type="text" name="zipcode" class="w3-input" id="zip" placeholder="Enter the Student's Zip Code." required>
        <label for="phonenumber">Phone number</label>
        <input type="tel" id="phonenumber" name="phonenumber" type="text" class="w3-input" placeholder="Enter the Student's Phone Number.">
        <label for="credits registered">Credits registered</label>
        <input type="number" id="credits" maxlength="2" name="credits" type="text" class="w3-input" placeholder="Enter the Number of Credits Registered." required>
        <br>
        <button name="save" type="submit" class="w3-button w3-teal">Save</button>
        <button name="proceed" type="submit" class="w3-button w3-teal">Proceed</button>
    </form>
</div>