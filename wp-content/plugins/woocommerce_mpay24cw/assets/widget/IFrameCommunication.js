/**
 * JS to communicate with the mPAY24 IFrame while wigdet authorization.<br>
 * Enables the pay button, if mPAY24 has validated the user input.
 */
window.onload = new function() {
	
	window.addEventListener("message", checkValid, false);
	var butt = document.getElementById("paybutt");
	
	function checkValid(form) {
		var data = JSON.parse(form.data);
		// if true unlock button for payment
		if (data.valid === "true") {
			butt.disabled = false;
		} else if(!butt.disabled) {
			butt.disabled = true;
		}
	}
	
}
