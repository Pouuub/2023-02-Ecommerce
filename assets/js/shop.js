import noUiSlider from 'nouislider';
import Filter from './modules/Filter';

new Filter(document.querySelector('.js-filter'))


//price slider
const slider = document.getElementById('price-slider');

if (slider) {
    const min = document.getElementById('min');
    const max = document.getElementById('max');
    const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10;
    const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10;
    const range = noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 1000000,
        range: {
            'min': minValue,
            'max': maxValue
        }
    })
    range.on('slide', function (value, handle) {
        if (handle === 0) {
            min.value = Math.round(value[0]);
        }
        if (handle === 1) {
            max.value = Math.round(value[1]);
        }
    })
    range.on('end', function (values, handle) {
        min.dispatchEvent(new Event('change'));
        max.dispatchEvent(new Event('change'));
    })
    ;
}

//event change sur keyup des inputs (recherche ajax)
const form = document.querySelector('.js-filter-form');

form.querySelectorAll('input').forEach(input => {
    input.addEventListener("keyup", (event) => {
        input.dispatchEvent(new Event('change'));
    })
})