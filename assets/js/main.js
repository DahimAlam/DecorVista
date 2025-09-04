const password = document.getElementById("password");
if(password){
  const bar = document.getElementById("strength-bar");
  password.addEventListener("input", () => {
    let val = password.value;
    let strength = 0;
    if (val.match(/[a-z]/)) strength++;
    if (val.match(/[A-Z]/)) strength++;
    if (val.match(/[0-9]/)) strength++;
    if (val.match(/[@$!%*?&]/)) strength++;
    if (val.length >= 8) strength++;

    bar.className = "";
    if (strength <= 2) {
      bar.classList.add("weak");
    } else if (strength <= 4) {
      bar.classList.add("medium");
    } else {
      bar.classList.add("strong");
    }
  });
}
