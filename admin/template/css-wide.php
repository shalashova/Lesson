/** CSS **/

/*
 * CSS wide
 *
 */


.wrapper{
	/* main wrapper */
	width:96%;
}
#header .wrapper{
	width:98%;
	margin-right:2%;
} 
.wrapper .nav{
	/* top header nav wrapper */
	width:99%;
}

.wrapper .nav li:first-child, #sitename {
	/* breathing space for tabs */
	margin-left: 35px;
}

.wrapper table {
	/* tables in wrapper, eg page management lists */
	width:99%;
}

#maincontent{
	/* wrapper for admin inputs */
	width:70%;
	/* margin-left: 35px; */
}
#sidebar{
	/* wrapper for admin inputs */
	width:28%;
  margin-left: 2%;
}
textarea, form input.title{
	/* resize backend textareas */
	/* outline backend administrative input fields for emphasis */
	width:99% ;
}

form.manyinputs textarea{
	/* resize backend textareas for components */
	width:100% ;
}
