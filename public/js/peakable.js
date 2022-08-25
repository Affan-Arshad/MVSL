export function makePeakable(selector) {
    const showPassword = (e) => {
        const peakableWrapper = e.target.parentElement
        const passwordField = peakableWrapper.querySelector('input')

        peakableWrapper.classList.add('peakableVisible')
        peakableWrapper.classList.remove('passwordHidden')
        passwordField.setAttribute('type', passwordField.getAttribute('type') == 'password' ? 'text' : 'password')
    }
    const hidePassword = (e) => {
        const peakableWrapper = e.target.parentElement
        const passwordField = peakableWrapper.querySelector('input')

        peakableWrapper.classList.remove('peakableVisible')
        peakableWrapper.classList.add('passwordHidden')
        passwordField.setAttribute('type', 'password')
    }
    const wrapInTemplate = (peakable) => {
        // create the wrapper
        const peakableWrapper = document.createElement('div')
        peakableWrapper.classList.add('peakableWrapper')
        peakableWrapper.classList.add('passwordHidden')

        // create img used as icon for peaking password
        const img = document.createElement('img')
        img.setAttribute('src', '/assets/show-password.jpg')

        // attach listeners to img
        img.addEventListener('mousedown', showPassword)
        img.addEventListener('mouseup', hidePassword)
        img.addEventListener('mouseout', hidePassword)

        // put img inside wrapper
        peakableWrapper.append(img)

        // put clone of element inside wrapper
        peakableWrapper.append(peakable.cloneNode())

        // place wrapper above the original element
        peakable.parentNode.insertBefore(peakableWrapper, peakable.nextSibling)

        // remove the original element
        peakable.remove()
    }

    const peakables = document.querySelectorAll(selector + '[type=password]')
    if (!peakables.length) {
        console.warn('peakable.js: Could not find any password inputs with selector ( ' + selector + ' )')
    } else {
        peakables.forEach(peakable => {
            wrapInTemplate(peakable)
        });
    }
}