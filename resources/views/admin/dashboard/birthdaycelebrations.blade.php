<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	  <input type="hidden" id="APP_URL" value="{{url('/')}}">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
		@import url("https://fonts.googleapis.com/css2?family=Reenie+Beanie&display=swap");
*,
*::before,
*::after {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

/* ============ -- VARIABLE -- =========== */
:root {
  --bg-clr: #593861;
  --bg-clr-alt: #3b2640;
  --txt-clr: #fef7ff;
  --orange-clr: #ffb58c;
}
/* ------------------------------------ */

/* ============ -- BASE -- =========== */
.container {
  margin: 2rem;

}
.card {
  background: linear-gradient(108.72deg, #fef7ff1f 0%, #fbf9fb05 100%);
  -webkit-backdrop-filter: blur(5px);
  backdrop-filter: blur(5px);
  border-radius: 20px;
  border: thin solid #fef7ff36;
}

/* ----------------------------------- */

body {
  font-family: "Faster One", sans-serif;
  background-color: var(--bg-clr-alt);
  color: var(--txt-clr);
  height: 90vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  animation-name: bgchange;
  animation-fill-mode: forwards;
  animation-duration: 2s;
  animation-delay: 4200ms;
  animation-timing-function: ease-in;
}
@keyframes bgchange {
  from {
    background-color: var(--bg-clr-alt);
  }
  to {
    background-color: var(--bg-clr);
  }
}


@keyframes sungoup {
  from {
    right: -1rem;
    top: 35rem;
  }
  to {
    right: 10rem;
    top: 0;
  }
}

.bxs-rocket {
  z-index: -1;
  color: var(--orange-clr);
  font-size: 3rem;
  position: absolute;
  bottom: 0;
  transform: translate(-50%, -50%) rotate(-45deg);
  animation-name: goup;
  animation-fill-mode: forwards;
  animation-duration: 3s;
  animation-timing-function: ease-in;
}
.rocket-one {
  left: 30%;
  animation-delay: 6000ms;
}
.rocket-two {
  left: 50%;
  animation-delay: 7000ms;
}
.rocket-three {
  left: 70%;
  animation-delay: 8000ms;
}
@keyframes goup {
  from {
    bottom: 0;
  }
  to {
    bottom: 100%;
  }
}

.dates-container {
  display: flex;
  margin-top: 5rem;
  position: relative;
  font-family: "Reenie Beanie", cursive;
}
.celeb {
  z-index: -1;
  width: 300px;
  height: 300px;
  position: absolute;
  top: 20%;
  right: -38%;
  transform: translate(-50%, -50%) scale(0);
  animation-name: turi;
  animation-fill-mode: forwards;
  animation-duration: 1s;
  animation-delay: 4120ms;
}
@keyframes turi {
  from {
    transform: translate(-50%, -50%) scale(0);
  }
  to {
    transform: translate(-50%, -50%) scale(1);
  }
}
.f-day {
  z-index: -1;
  width: 300px;
  height: 300px;
  position: absolute;
}
.day-one {
  top: 20%;
  left: 7rem;
  transform: translate(-50%, -50%);
}
.day-two {
  top: 20%;
  left: 18rem;
  transform: translate(-50%, -50%);
}
.tuturi {
  width: 300px;
  height: 300px;
  position: absolute;
  top: 10%;
  left: 0;
}
.tuturi-2 {
  left: auto;
  right: 0;
}
.smile {
  font-size: 2.5rem;
  letter-spacing: 2rem;
  transform: scale(0);
  transform-origin: top;
  animation-name: smiled;
  animation-fill-mode: forwards;
  animation-duration: 2s;
  animation-delay: 14000ms;
}
@keyframes smiled {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}
.date-no {
  display: flex;
  align-items: center;
  justify-content: center;

  width: 140px;
  height: 110px;

  padding-left: 1rem;
  margin-right: 2.5rem;
  font-size: 4rem;
  letter-spacing: 1rem;
}
.ro {
  animation-name: flipc;
  animation-fill-mode: forwards;
  animation-duration: 1s;
  animation-delay: 16000ms;
  transform: rotateY(0);
}
@keyframes flipc {
  from {
    transform: rotateY(0);
  }
  to {
    transform: rotateY(360deg);
  }
}
.year {
  width: 230px;
}
.date-no:last-child {
  margin-right: 0;
}

/* ---------------- */
.day-description {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 2rem;
  width: 700px;
  height: 300px;
}
.bday-desc-letters-container {
  display: flex;
  font-family: "Reenie Beanie", cursive;
  margin-bottom: 2rem;
  margin-top: 0.5rem;
}
.bday-name-letter {
  font-size: 2rem;
  margin-right: 1.5rem;
}
.divid {
  width: 1px;
  height: 1px;
  margin: 0 1rem;
}
.bday-name-letter:last-child {
  margin-right: 0;
}
.bday-desc-letter {
  font-size: 3rem;
  margin-right: 1.8rem;
}
.bday-desc-letter:last-child {
  margin-right: 0;
}

.lottie-firework {
  width: 500px;
  height: 500px;
  position: absolute;
  bottom: 0;
  transform: scale(0);
  transition: transform 1s;
  animation-name: lottie-firework-up;
  animation-fill-mode: forwards;
  animation-duration: 1s;
  animation-delay: 10000ms;
  animation-timing-function: ease-in;
}

@keyframes lottie-firework-up {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

/* ---------- */
.mountain-wave {
  z-index: -1;
  position: absolute;
  bottom: -3rem;
}

	</style>
</head>

<body class="container">
<?php 
$user=Sentinel::getUser();


$birthday=date_create($user->birthday);


?>

  <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_fJ7CVd.json" background="transparent" speed="1" class="tuturi" loop autoplay></lottie-player>
  <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_fJ7CVd.json" background="transparent" speed="1" class="tuturi tuturi-2" loop autoplay></lottie-player>
  <div class="dates-container">
    <lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_9xgG23.json" background="transparent" speed=".5" class="day-one f-day" loop autoplay></lottie-player>
    <div class="date-no day card ro">{{date_format($birthday,"d")}}</div>
    <lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_9xgG23.json" background="transparent" speed=".5" class="day-two f-day" loop autoplay></lottie-player>
    <div class="date-no mouth card ro">{{date_format($birthday,"m")}}</div>
    <div class="date-no year card ro">{{date_format($birthday,"Y")}}</div>
    <lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_9xgG23.json" background="transparent" speed=".5" class="celeb" loop autoplay></lottie-player>
  </div>

  <i class='bx bxs-rocket rocket rocket-one'></i>
  <i class='bx bxs-rocket rocket-two'></i>
  <i class='bx bxs-rocket rocket-three'></i>

  <div class="smile">🥳😁🔥</div>

  <div class="day-description card">
   
    <div class="birthday-titles-container bday-desc-letters-container">
      <h2 class="bday-desc-letter">HAPPY</h2>
    
   

       <h2 class="bday-desc-letter">BIRTHDAY</h2>
     <span class="divid"></span>
    </div>

     <div class="bday-names-container bday-desc-letters-container">
      <h1 class="bday-name-letter">{{$user->name}}</h1>
     
    
     
    </div>
       <span>Please Wait 5 Seconds... Website will auto redirect</span>
  </div>

  <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_5hufvwkz.json" background="transparent" speed="1" class="lottie-firework" loop autoplay></lottie-player>
  <img src="https://raw.githubusercontent.com/r-e-d-ant/mthierry-bday/887159adfedabd8d1c3b6cdf3ba20abb4d55197f/assets/images/mountain.svg" alt="mountain" class="mountain-wave" style="max-width: 100%;">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <script type="text/javascript">
  	const bdayYear = document.querySelector(".year");

bdayYear.textContent = {{date_format($birthday,"Y")}};

var yearPlus = {{date_format($birthday,"Y")}};

const giveYear = () => {
  if (yearPlus != {{date('Y')}}) {
    yearPlus += 1;
    bdayYear.textContent = yearPlus;
  } else {
    bdayYear.textContent = {{date('Y')}};
  }
};

setTimeout(() => {
  setInterval(giveYear, 100);
}, 4000);

const celeb = document.querySelector(".celeb");

setTimeout(() => {
  celeb.removeAttribute("loop", "");

  var APP_URL=document.querySelector("#APP_URL").value;

  var url=APP_URL+'/Dashboard';
        window.location.href = url;
}, 4120);

  </script>
</body>

</html>