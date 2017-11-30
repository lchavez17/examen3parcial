$('form').validate({
	rules: {
		clave: "required",
		clave2: {
			equalTo: "#clave"
		}
	},
	errorPlacement: function(error, element) {}
});