const menubtn = document.querySelector(".flag__arrow");
const menuContent = document.querySelector(".flag__container");
menubtn.addEventListener("click", ()=> {
   menuContent.classList.toggle("addview");
});
