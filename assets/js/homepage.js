/* slider */
const slides = document.querySelectorAll('#slider div');
const choices = document.querySelectorAll('#choice-slide div');
var activeSlide = 0;
const nbslide = 4;
const timeInterval = 5000; //mill

const changeSlide = () => {
    if (activeSlide < 3) {
        slides[activeSlide].classList.toggle("opacity-100");
        slides[activeSlide+1].classList.toggle("opacity-100");
        choices[activeSlide].classList.toggle("bg-primary");
        choices[activeSlide+1].classList.toggle("bg-primary");
        activeSlide++;
    } else {
        slides[activeSlide].classList.toggle("active-slide");
        slides[0].classList.toggle("active-slide");
        choices[activeSlide].classList.toggle("bg-primary");
        choices[0].classList.toggle("bg-primary");
        activeSlide = 0;
    }
};

let slideInterval = window.setInterval(changeSlide, timeInterval);
choices.forEach(choice => {
    choice.addEventListener("click", function () {
        slides[activeSlide].classList.toggle("active-slide");
        slides[parseInt(choice.dataset.id)].classList.toggle("active-slide");
        choices[activeSlide].classList.toggle("bg-primary");
        choices[parseInt(choice.dataset.id)].classList.toggle("bg-primary");
        activeSlide = parseInt(choice.dataset.id);
        window.clearInterval(slideInterval);
        slideInterval = window.setInterval(changeSlide, timeInterval);
    })
});

//carousel

/*--------------------
Vars
--------------------*/
let progress = 50
let startX = 0
let active = 0
let isDown = false

/*--------------------
Contants
--------------------*/
const speedWheel = 0.02
const speedDrag = -0.1

/*--------------------
Get Z
--------------------*/
const getZindex = (array, index) => (array.map((_, i) => (index === i) ? array.length : array.length - Math.abs(index - i)))

/*--------------------
Items
--------------------*/
const $items = document.querySelectorAll('.carousel-item')
const $cursors = document.querySelectorAll('.cursor')

const displayItems = (item, index, active) => {
  const zIndex = getZindex([...$items], active)[index]
  item.style.setProperty('--zIndex', zIndex)
  item.style.setProperty('--active', (index-active)/$items.length)
}

/*--------------------
Animate
--------------------*/
const animate = () => {
  progress = Math.max(0, Math.min(progress, 100))
  active = Math.floor(progress/100*($items.length-1))
  
  $items.forEach((item, index) => displayItems(item, index, active))
}
animate()

/*--------------------
Click on Items
--------------------*/
$items.forEach((item, i) => {
  item.addEventListener('click', () => {
    progress = (i/$items.length) * 100 + 10
    animate()
  })
})

/*--------------------
Handlers
--------------------*/
const handleWheel = e => {
  const wheelProgress = e.deltaY * speedWheel
  progress = progress + wheelProgress
  animate()
}

const handleMouseMove = (e) => {
  if (e.type === 'mousemove') {
    $cursors.forEach(($cursor) => {
      $cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`
    })
  }
  if (!isDown) return
  const x = e.clientX || (e.touches && e.touches.clientX) || 0
  const mouseProgress = (x - startX) * speedDrag
  progress = progress + mouseProgress
  startX = x
  animate()
}

const handleMouseDown = e => {
  isDown = true
  startX = e.clientX || (e.touches && e.touches.clientX) || 0
}

const handleMouseUp = () => {
  isDown = false
}

/*--------------------
Listeners
--------------------*/
document.addEventListener('mousewheel', handleWheel)
document.addEventListener('mousedown', handleMouseDown)
document.addEventListener('mousemove', handleMouseMove)
document.addEventListener('mouseup', handleMouseUp)
document.addEventListener('touchstart', handleMouseDown)
document.addEventListener('touchmove', handleMouseMove)
document.addEventListener('touchend', handleMouseDown)