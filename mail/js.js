console.log("HEllo ");

const params=new URLSearchParams(window.location.search);
const message=params.get("message");
const type=params.get("type");

if (message){
    const msg_tag=document.getElementById("message");
    msg_tag.textContent=message;
    msg_tag.classList.add(type);
    if (msg_tag) {
        msg_tag.classList.add('active');
        setTimeout(function() {
            msg_tag.style.display = 'none';
            history.replaceState({}, document.title, window.location.pathname);
        }, 4000); // Hide after 10 seconds
    }
}