
function  closeModal(a)
{
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event)
  {
      if (event.target == document.getElementById(a))
      {
          modal.style.display = "none";
      }
  }
}
