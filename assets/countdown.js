;(function () {
  document.querySelectorAll('.countdown').forEach(function (countdown) {
    const deadline = new Date(countdown.dataset.date)

    const elDays = countdown.querySelector('.countdown-days')
    const elHours = countdown.querySelector('.countdown-hours')
    const elMinutes = countdown.querySelector('.countdown-minutes')
    const elSeconds = countdown.querySelector('.countdown-seconds')

    const updateTimer = () => {
      const now = new Date()
      const diff = Math.max(0, deadline - now)

      const days = Math.floor(diff / (1000 * 60 * 60 * 24))
      const hours = Math.floor((diff / (1000 * 60 * 60)) % 24)
      const minutes = Math.floor((diff / (1000 * 60)) % 60)
      const seconds = Math.floor((diff / 1000) % 60)

      elDays.textContent = String(days).padStart(2, '0')
      elHours.textContent = String(hours).padStart(2, '0')
      elMinutes.textContent = String(minutes).padStart(2, '0')
      elSeconds.textContent = String(seconds).padStart(2, '0')

      if (diff === 0) {
        clearInterval(timerId)
      }
    }

    updateTimer()
    const timerId = setInterval(updateTimer, 1000)
  })
})()
