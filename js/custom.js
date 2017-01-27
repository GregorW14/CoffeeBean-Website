/*
* 	Validate login form.
*
*   Description: 	Checks if the username and password fields are
*					empty and posts a dialog box to the user if so.
*
*	Please note:	It checks both username and password together and 
*					then seperately to minimise the number of dialog 
*					boxes needed.
*/
function validateStaffLoginForm() 
{
	var username = document.getElementById("usernameS");
	var password = document.getElementById("passwordS");
	var error = document.getElementById("errorS");
	
	// If both username and password are empty
	if ((username.value == "") && (password.value == ""))
	{
		error.innerHTML = "Username and password cannot be empty!"
		return false;
	}
	
	// If just username is empty
	if (username.value == "")
	{
		error.innerHTML = "Username cannot be empty!"
		return false;
	}
	
	// If password is empty
	if (password.value == "")
	{
		error.innerHTML = "Password cannot be empty!"
		return false;
	}
	
	// Form is valid
	return true;
}

/*
* 	Validate login form.
*
*   Description: 	Checks if the username and password fields are
*					empty and posts a dialog box to the user if so.
*
*	Please note:	It checks both username and password together and 
*					then seperately to minimise the number of dialog 
*					boxes needed.
*/
function validateCustomerLoginForm() 
{
	var username = document.getElementById("usernameC");
	var password = document.getElementById("passwordC");
	var error = document.getElementById("errorC");
	
	// If both username and password are empty
	if ((username.value == "") && (password.value == ""))
	{
		error.innerHTML = "Username and password cannot be empty!"
		return false;
	}
	
	// If just username is empty
	if (username.value == "")
	{
		error.innerHTML = "Username cannot be empty!"
		return false;
	}
	
	// If password is empty
	if (password.value == "")
	{
		error.innerHTML = "Password cannot be empty!"
		return false;
	}
	
	// Form is valid
	return true;
}

window.onload = function() {
  choosePageMessage();
};

/*
* 	Choose a cheesy coffee shop quote to display on the page.
*
*   Description: 	Generates a random number and uses it as the index
					for the message array to pick a random quote.
*/
function choosePageMessage() 
{
	var message = document.getElementById("message");
	var messageArray = ["Espresso yourself.", 
						"Stay grounded.", 
						"Better latte than never.", 
						"Soup of the day: coffee.",
						"How did the hipster burn his tongue? He sipped his coffee before it was cool.",
						"How do you feel when there is no coffee? Depresso.",
						"A latte fun.",
						"What is the best Beatles song? ...'Latte Be'."];
	var messageIndex = Math.round(Math.random()*7);
	
	message.innerHTML = messageArray[messageIndex];
	return true;
}