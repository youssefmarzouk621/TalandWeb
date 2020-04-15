const opendmodalButtons = document.querySelectorAll('[data-dmodal-target]')
const closedmodalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

opendmodalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const dmodal = document.querySelector(button.dataset.dmodalTarget)
    opendmodal(dmodal)
  })
})

overlay.addEventListener('click', () => {
  const dmodals = document.querySelectorAll('.dmodal.active')
  dmodals.forEach(dmodal => {
    closedmodal(dmodal)
  })
})

closedmodalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const dmodal = button.closest('.dmodal')
    closedmodal(dmodal)
  })
})

function opendmodal(dmodal) {
  if (dmodal == null) return
  dmodal.classList.add('active')
  overlay.classList.add('active')
}

function closedmodal(dmodal) {
  if (dmodal == null) return
  dmodal.classList.remove('active')
  overlay.classList.remove('active')
}