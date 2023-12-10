function updateDate() {
    const dateElement = document.getElementById('date');
    const currentDate = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString('id-ID', options);
    dateElement.textContent = formattedDate;
}

updateDate();

function showTime() {
    const clockElement = document.getElementById('clock');

    function updateTime() {
        const date = new Date();
        const hours = date.getHours();
        const minutes = date.getMinutes();
        const seconds = date.getSeconds();

        const formattedHours = (hours < 10) ? '0' + hours : hours;
        const formattedMinutes = (minutes < 10) ? '0' + minutes : minutes;
        const formattedSeconds = (seconds < 10) ? '0' + seconds : seconds;

        const time = formattedHours + ":" + formattedMinutes + ":" + formattedSeconds;
        clockElement.textContent = time;
    }

    updateTime();

    setInterval(updateTime, 1000);
}

showTime();
