<script setup>
import { callWithAsyncErrorHandling, ref } from "vue";

let totalVuePackages = ref(null);
let isTemperatureHigh = ref(false);
let isHumidityHigh = ref(false);
let isSoundHigh = ref(false);
let imgToggle = ref(false);
let sumTemperature = ref(0);
let avgTemperature = ref(0);
let sumHumidity = ref(0);
let avgHumidity = ref(0);
let sumSound = ref(0);
let avgSound = ref(0);
let count = ref(0);

async function updateData() {
  const response = await fetch("http://apiv2.phil5521.aspitcloud.dk/all");
  const data = await response.json();
  totalVuePackages.value = await data.data;
  await calcAvg();
  if (totalVuePackages.value[count.value - 1].temperature >= 30) {
    isTemperatureHigh.value = true;
  } else {
    isTemperatureHigh.value = false;
  }
  if (totalVuePackages.value[count.value - 1].humidity >= 40) {
    isHumidityHigh.value = true;
  } else {
    isHumidityHigh.value = false;
  }
  if (totalVuePackages.value[count.value - 1].loud >= 350) {
    isSoundHigh.value = true;
  } else {
    isSoundHigh.value = false;
  }
}
async function calcAvg() {
  count.value = totalVuePackages.value.length;
  sumTemperature.value = 0;
  sumHumidity.value = 0;
  sumSound.value = 0;

  totalVuePackages.value.forEach((element) => {
    sumTemperature.value += element.temperature;
  });
  totalVuePackages.value.forEach((element) => {
    sumHumidity.value += element.humidity;
  });
  totalVuePackages.value.forEach((element) => {
    sumSound.value += element.loud;
  });

  avgTemperature.value = sumTemperature.value / count.value;
  avgHumidity.value = sumHumidity.value / count.value;
  avgSound.value = sumSound.value / count.value;
}

async function timer() {
  updateData();
  const myTimeout = setInterval(updateData, 2500);
}

timer();

function imgMeme(){
  console.log(imgToggle);
  if(imgToggle.value == false){
    imgToggle.value = true;
  } else {
    imgToggle.value = false;
  }
}
</script>

<template>
  <div class="title">
    <img
      class="headerLogo"
      src="src\assets\ArduinoLogo.png"
      alt="Arduino logo"
    />
    <span class="header">
      <h1 class="headerH1">Arduino Free Samples Website</h1>
      <h4 class="headerH4">Live Temperature of the Room</h4>
    </span>
  </div>

  <div class="body">
    <div class="displayMain">
      <div class="display">
        <h1>Average</h1>
        <div class="temperature">
          <h2>Temperature</h2>
          <p class="value" v-if="totalVuePackages != null">
            {{ parseInt(avgTemperature) }}
          </p>
        </div>
        <div class="humidity">
          <h2>Humidity</h2>
          <p class="value" v-if="totalVuePackages != null">
            {{ parseInt(avgHumidity) }}
          </p>
        </div>
        <div class="sound">
          <h2>Sound</h2>
          <p class="value" v-if="totalVuePackages != null">
            {{ parseInt(avgSound) }}
          </p>
        </div>
      </div>

      <div class="statistics">
        <div class="stat">
          <h1>Statistics</h1>
          <div class="temperature">
            <h2>Temperature</h2>
            <div class="warnFlex">
              <p class="value valueTemperature" v-if="totalVuePackages != null">
                {{ parseInt(totalVuePackages[count - 1].temperature) }}
              </p>
              <span
                class="boxColor boxTemperature"
                :class="{ warningRed: isTemperatureHigh }"
              ></span>
            </div>
          </div>
          <div class="humidity">
            <h2>Humidity</h2>
            <div class="warnFlex">
              <p class="value valueHumidity" v-if="totalVuePackages != null">
                {{ parseInt(totalVuePackages[count - 1].humidity) }}
              </p>
              <span
                class="boxColor boxHumidity"
                :class="{ warningRed: isHumidityHigh }"
              ></span>
            </div>
          </div>
          <div class="sound">
            <h2>Sound</h2>
            <div class="warnFlex">
              <p class="value valueSound" v-if="totalVuePackages != null">
                {{ parseInt(totalVuePackages[count - 1].loud) }}
              </p>
              <span
                class="boxColor boxSound"
                :class="{ warningRed: isSoundHigh }"
              ></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="picture">
        <div class="filter">
          <img v-if="!imgToggle"
            class="arduinoImg"
            src="src/assets/Arduino-picture.png"
            alt="Arduino Picture"
          />
          <img v-if="imgToggle"
            class="arduinoImg"
            src="src\assets\patrickmeme.png"
            alt="Arduino Picture"
          />
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <label class="footerLabel">Project Contributors</label>
    <div class="footerContent">
      <div class="footerContainer">
        <h3 class="footerH3">Martin Hvidsteen</h3>
        <p class="footerP">Team Leader</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Phillip Engelhardt Eis</h3>
        <p class="footerP">Database - API</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Mads Møller Nørgaard</h3>
        <p class="footerP">Arduino Temperature Humidity and Program</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Niklas Torup Ingvordsen</h3>
        <p class="footerP">Arduino Temperature Humidity and Program</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Jonas Kristoffer Mortensen</h3>
        <p class="footerP">Website Connection To API</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Nikolai Frederik Olesen</h3>
        <p class="footerP">Arduino Sound</p>
      </div>
      <div class="footerContainer">
        <h3 class="footerH3">Klement Baastrup Johansen</h3>
        <p class="footerP">Chief of Security Yoga Ball</p>
      </div>
      <button class="footerContainer btn" @click="imgMeme">
        <h3 class="footerH3">Patrick Wulff Holst</h3>
        <p class="footerP">Emmissary of Foreign Affairs</p>
      </button>
    </div>
  </footer>
</template>

<style>
.title {
  display: flex;
  height: 100px;
  padding-left: 8%;
  vertical-align: top;
  box-shadow: 0 4px 2px -2px gray;
}
.headerLogo,
.header {
  margin-left: 1%;
}
.headerH4 {
  margin-top: -20px;
  margin-left: -50%;
}

.body {
  align-items: center;
  margin: 80px 200px;
}
.btn{
}
.display,
.stat {
  display: flex;
  flex-direction: column;
  width: 240px;
  box-shadow: 0 3px 2px -2px gray;
}
.displayMain {
  display: flex;
  justify-content: space-around;
  margin-bottom: 50px;
}
.content {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  align-items: center;
}
.arduinoImg {
  opacity: 0.85;
}
.filter, .arduinoImg {
  display: flex;
  justify-content: center;
  align-items: center;
  background: black;
  width: 500px;
  height: 300px;
}
.arduinoImg,
.filter {
  border-radius: 5px;
}
.picture {
  margin: 50px 0;
}

.warningP {
  font-weight: Bolder;
  font-size: 18px;
}
.boxColor {
  height: 20px;
  width: 20px;
  border: 2px solid black;
  border-radius: 100px;
  margin: 8px;
}
.warnFlex {
  display: flex;
  align-items: center;
}
.warningRed {
  background: red;
}

.temperature,
.humidity,
.sound {
  align-items: center;
  display: flex;
  justify-content: space-between;
}
.value {
  margin-left: 20px;
  font-size: 22px;
}

.footer {
  background: LightGray;
  box-shadow: 0px -2px 4px gray;
  padding-top: 20px;
  padding-bottom: 50px;
}
.footerContent {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
.footerContainer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 50px;
  width: 350px;
  margin: 25px 35px;
  box-shadow: 0 1.6px 2px -1.5px rgb(90, 90, 90);
}
.footerLabel {
  font-weight: bold;
  font-size: 20px;
}
.footerP {
  text-align: right;
}
.footerH3 {
  text-align: left;
}

@media screen and (max-width: 1000px) {
  .title {
    font-size: 14px;
  }
  .content {
    flex-direction: column;
    margin: 20px 0;
  }
  .headerLogo {
    height: 80px;
  }
  .filter, .arduinoImg {
    width: 280px;
    height: 180px;
  }
  .body {
    width: 100%;
    margin: 80px 0;
  }
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>