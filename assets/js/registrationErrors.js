var form = document.getElementById("form");
form.addEventListener("submit", function(e){
    e.preventDefault();
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/register");
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.onreadystatechange = function() {
        console.log(this.status);
        if (this.readyState === XMLHttpRequest.DONE && this.status === 422) {
            var errors = JSON.parse(xhr.responseText).errors;
            
            var ul = document.getElementById('errors');
            ul.classList.add('bg-red-500');
            ul.classList.add('p-4');
            for (key in errors) {      
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(errors[key][0]));
                ul.appendChild(li);
            }
        }
            
        if (this.status === 200) {
            document.cookie = "flavor=choco; SameSite=Strict; Secure;";
            window.location.replace("/wait/mail");
        }
    }
    xhr.send(formData)
});