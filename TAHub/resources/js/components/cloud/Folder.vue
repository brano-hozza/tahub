<template>
  <div>
    <transition name="curt">
      <div v-if="createFolder || uploadFile" class="curtains" v-on:click="skry"></div>
    </transition>
    <div class="cloud-menu">
      <h2>Tahub - {{name}}</h2>
      <p v-on:click="rootFold">Hlavný adresár</p>
      <p v-on:click="createFolder=true">Vytvoriť priecinok</p>
      <p v-on:click="uploadFile=true">Pridať súbor</p>
    </div>
    <transition
      mode="out-in"
      name="fade"
      enter-active-class="animate__animated animate__zoomIn"
      leave-active-class="animate__animated animate__zoomOut"
    >
      <div v-if="createFolder===true" class="create-folder-tab">
        <div class="up">
          <h2>Vytvoriť priečinok</h2>
          <p>
            Vytváraj priečinky pre prehľadnejšie
            ukladanie svojich dát
          </p>
        </div>

        <div class="folder-preview">
          <img src="images/folder-icon.png" />
          <p v-if="!folder_name">Folder name</p>
          <p v-else>{{folder_name}}</p>
        </div>

        <div class="down">
          <transition
            mode="out-in"
            name="fade"
            enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut"
          >
            <p v-if="input_error===0" class="folder-error-alert" key="uno"></p>
            <p v-else-if="input_error===1" class="folder-error-alert" key="dos">Nepovolené znaky</p>
            <p
              v-else-if="input_error===2"
              class="folder-error-alert"
              key="tres"
            >Priečinok už existuje</p>
            <p v-else-if="input_error===3" class="folder-error-alert" key="tres">
              Priečinok musí mať
              názov
            </p>
          </transition>

          <input
            v-on:keypress.enter="enter"
            type="text"
            v-model="folder_name"
            placeholder="Názov pričinka"
            class="folder-input"
          />
          <button v-on:click="createFolder=false; folder_name=''" class="folder-cancel">Zavrieť</button>
          <transition
            mode="out-in"
            name="fade"
            enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut"
          >
            <button
              id="enter-button"
              v-if="active"
              v-on:click="addFolder"
              class="folder-submit"
              key="active"
            >Pridaj</button>
            <button disabled v-if="!active" class="folder-submit-disabled" key="disabled">Pridaj</button>
          </transition>
        </div>
      </div>
      <div v-if="uploadFile===true" class="create-folder-tab">
        <div class="up">
          <h2>Nahraj subor</h2>
          <p>Nahraj co len chces hlavne nech to neni folder</p>
        </div>
        <div class="down">
          <input type="file" id="file" ref="file" v-on:change="handleFile" multiple />
          <br />
          <button v-on:click="uploadFile=false" class="folder-cancel">Zavrieť</button>
          <button v-on:click="addFile" class="folder-submit">Pridaj</button>
        </div>
      </div>
    </transition>

    <div class="cloud-body">
      <div class="cloud-inner-body">
        <div>
          <h1 class="folder-path" v-if="current_folder === '/'">/</h1>
          <span
            v-else
            class="folder-path-wrapper"
            v-for="(name, index) in current_folder.split('/')"
            :key="name"
          >
            <h1 class="folder-path" v-on:click="zmenAdresar(index)">{{name}}/</h1>
          </span>
          <p class="back" v-if="current_folder !== '/'" v-on:click="back">
            <span class="material-icons">arrow_back</span>Back
          </p>
        </div>
        <h2 class="cloud-title">Tvoje priečinky</h2>

        <div id="folders" class="folders">
          <div v-for="folder in folders" :key="folder" class="folder">
            <div>
              <div class="folder-image-wrapper">
                <img
                  class="folder-image"
                  src="images/folder-icon.png"
                  v-on:click="presmeruj(folder)"
                />
              </div>
              <p v-on:click="presmeruj(folder)">{{folder}}</p>
              <p class="remove" v-on:click="removeFolder(folder)">(Remove)</p>
            </div>
          </div>
        </div>

        <hr />
        <h2 class="cloud-title">Tvoje subory</h2>
        <div id="files" class="files">
          <div v-for="file in files" class="file" :key="file">
            <div class="file-image-wrapper">
              <img class="file-image" src="images/folder-icon.png" v-on:click="stiahni(file)" />
            </div>
            <p>{{file}}</p>
            <p class="remove" v-on:click="removeFile(file)">(Remove)</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Folder",
  data() {
    return {
      current_folder: "/",
      folders: [],
      files: [],
      folder_name: "",
      file: [],
      name: "",
      active: false,
      input_error: 0,
      createFolder: false,
      uploadFile: false
    };
  },

  mounted() {
    var storage = window.localStorage;
    this.name = storage.getItem("name");
  },

  created() {
    console.log("Ziskavam");
    let str = window.localStorage;
    let token = str.getItem("token");
    axios
      .post("api/cloud/folders", {
        api_token: token
      })
      .then(response => {
        this.folders = response.data["dirs"];
      })
      .catch(e => console.log(e));
    axios
      .post("api/cloud/files", {
        api_token: token
      })
      .then(response => {
        this.files = response.data["files"];
      })
      .catch(e => console.log(e));
  },

  watch: {
    folder_name: function(val) {
      this.active = val.length > 0;
      if (val.length >= 20) {
        this.folder_name = val.substring(0, val.length - 1);
      }

      if (val.length > 0) {
        this.active = true;
        var dnu = true;
        for (let i = 0; i < this.folders.length; i++) {
          if (
            this.folder_name.toLowerCase() === this.folders[i].toLowerCase()
          ) {
            dnu = false;
            this.input_error = 2;
            console.log("bad");
          }
        }
        if (dnu !== false) {
          this.input_error = 0;
        }
        this.active = dnu;
      } else {
        this.active = false;
      }
    }
  },

  methods: {
    skry() {
      this.createFolder = false;
      this.uploadFile = false;
    },

    enter() {
      let button = document.getElementById("enter-button");
      button.click();
    },

    removeFolder(folder) {
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders/delete", {
          api_token: token,
          path: this.current_folder,
          name: folder
        })
        .then(response => {
          console.log(response);
          this.folders = response.data["dirs"];
        })
        .catch(e => console.log(e));
    },
    removeFile(file) {
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/files/delete", {
          api_token: token,
          path: this.current_folder,
          name: file
        })
        .then(response => {
          console.log(response);
          this.files = response.data["files"];
        })
        .catch(e => console.log(e));
    },
    stiahni(file) {
      let str = window.localStorage;
      let token = str.getItem("token");
      axios({
        url: "api/cloud/files/download",
        method: "POST",
        data: {
          api_token: token,
          path: this.current_folder,
          name: file
        },
        responseType: "blob" // important
      }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", file); //or any other extension
        document.body.appendChild(link);
        link.click();
      });
    },
    back() {
      let arr = this.current_folder.split("/");
      if (arr.length == 2) this.current_folder = "/";
      else {
        arr.pop();
        this.current_folder = arr.join("/");
      }
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.folders = response.data["dirs"];
        })
        .catch(e => console.log(e));
      axios
        .post("api/cloud/files", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.files = response.data["files"];
        })
        .catch(e => console.log(e));
    },
    presmeruj(folder) {
      this.current_folder += this.current_folder == "/" ? folder : "/" + folder;
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.folders = response.data["dirs"];
        })
        .catch(e => console.log(e));
      axios
        .post("api/cloud/files", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.files = response.data["files"];
        })
        .catch(e => console.log(e));
    },
    rootFold() {
      this.current_folder = "/";
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.folders = response.data["dirs"];
        })
        .catch(e => console.log(e));
      axios
        .post("api/cloud/files", {
          api_token: token,
          path: this.current_folder
        })
        .then(response => {
          this.files = response.data["files"];
        })
        .catch(e => console.log(e));
    },
    handleFile() {
      this.file = Array.from(this.$refs.file.files);
    },
    addFolder() {
      if (this.folder_name === "") {
        this.input_error = 3;
      }
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders/add", {
          api_token: token,
          path: this.current_folder,
          name: this.folder_name
        })
        .then(response => {
          if (response.data["status_code"] !== 422) {
            console.log(response);
            this.createFolder = false;
            this.folder_name = "";
            this.folders = response.data["dirs"];
            this.input_error = 0;
            this.skry();
          } else {
            this.input_error = 1;
          }
        })
        .catch(e => {});
    },
    addFile() {
      if (this.file === []) {
        console.log("Nevybral si subor");
      } else {
        let str = window.localStorage;
        let token = str.getItem("token");
        let formData = new FormData();
        let index = this.file.length - 1;

        console.log(this.file);
        formData.append("file", this.file[index]);
        formData.append("path", this.current_folder);
        formData.append("api_token", token);
        axios
          .post("api/cloud/files/add", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            console.log(response);
            this.files = response.data["files"];
            this.file.pop();
            if (index != 0) {
              this.addFile();
            } else {
              this.skry();
            }
          })
          .catch(e => console.log(e));
      }
    },
    zmenAdresar(index){
      let cesta = this.current_folder.split('/');
      cesta.splice(index+1);
      cesta = cesta.join('/');
      console.log(cesta);
      let str = window.localStorage;
      let token = str.getItem("token");
      axios
        .post("api/cloud/folders", {
          api_token: token,
          path: cesta
        })
        .then(response => {
          this.folders = response.data["dirs"];
          this.current_folder = cesta;
        })
        .catch(e => console.log(e));
      axios
        .post("api/cloud/files", {
          api_token: token,
          path: cesta
        })
        .then(response => {
          this.files = response.data["files"];
          this.current_folder = cesta;
        })
        .catch(e => console.log(e));

    }
  }
};
</script>

<style scoped>
.animate__fadeIn {
  animation-duration: 0.2s;
}

.animate__fadeOut {
  animation-duration: 0.2s;
}

.animate__zoomIn {
  animation-duration: 0.5s;
}

.curt-enter-active,
.curt-leave-active {
  transition: opacity 0.5s;
}

.curt-enter, .curt-leave-to /* .fade-leave-active below version 2.1.8 */
 {
  opacity: 0;
}
.remove{
  color: var(--fnt-err);
}
.cloud-menu {
  margin-left: 6.3%;
  margin-top: 0.5rem;
}

.cloud-menu p {
  display: inline-block;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
  font-size: 1rem;
  padding: 0.8rem 0.5rem 0.8rem;
  border-radius: 1rem 1rem 0 0;
  transition-duration: 0.2s;
  cursor: pointer;
}

.cloud-menu p:hover {
  background-color: var(--btn-hover);
  color: var(--fnt-btn);
  transition-duration: 0.2s;
}

.cloud-menu h2 {
  display: inline-block;
  margin-right: 0.5rem;
  font-size: 1rem;
}

.cloud-body {
  background-color: var(--bg-secondary);
  margin: 0 auto;
  border-radius: 1.5rem 1.5rem 0 0;
}

.cloud-inner-body {
  padding-top: 2rem;
  width: 90%;
  margin: 0 auto;
}

.folders {
  display: flex;
  flex-flow: wrap;
  justify-content: flex-start;
  margin: 0 auto;
}

.folder-image-wrapper {
  perspective: 100px;
  position: relative;
}

.folder-image {
  height: 5rem;
  width: auto;
  margin: 0 auto;
  transition-duration: 0.2s;
  background-color: transparent;
  transform-style: preserve-3d;
  transform: rotateX(0deg);
  cursor: pointer;
}

.folder {
  position: relative;
  text-align: center;
  height: auto;
  width: 8rem;
  margin: 0.8rem;
  padding-top: 0.4rem;
  perspective: 0;
}
.folder-path {
  display: inline;
  font-size: 2rem;
}
.folder-path:hover{
  color:var(--btn);
  cursor: pointer;
}
.folder-path-wrapper {
  display: inline;
}

.folder-image:hover {
  transform: rotateX(-10deg);
}

.files {
  display: flex;
  flex-flow: wrap;
  justify-content: flex-start;
  margin: 0 auto;
}

.file p {
  font-size: 0.9rem;
  max-width: 6rem;
  margin: 0 auto;
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  overflow: hidden;
  text-overflow: ellipsis;
  cursor: pointer;
}

.file {
  position: relative;
  text-align: center;
  height: auto;
  width: 8rem;
  margin: 0.8rem;
  padding-top: 0.4rem;
  perspective: 0;
}

.file-image:hover {
  transform: rotateX(-10deg);
}

.folder p {
  font-size: 0.9rem;
  max-width: 6rem;
  margin: 0 auto;
  padding-top: 0.3rem;
  padding-bottom: 0.3rem;
  overflow: hidden;
  text-overflow: ellipsis;
  cursor: pointer;
}

.file-image-wrapper {
  perspective: 100px;
  position: relative;
}

.file-image {
  height: 5rem;
  width: auto;
  margin: 0 auto;
  transition-duration: 0.2s;
  background-color: transparent;
  transform-style: preserve-3d;
  transform: rotateX(0deg);
  cursor: pointer;
}

.cloud-title {
  font-size: 1.8rem;
  font-weight: bold;
  margin-left: 1.5rem;
  padding-top: 2rem;
  padding-bottom: 2rem;
}

.create-folder-tab {
  width: 20.5rem;
  position: absolute;
  z-index: 1;
  margin-left: calc(50% - 9rem);
  margin-top: 5%;
  -webkit-box-shadow: 2px 2px 27px -20px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 2px 27px -20px rgba(0, 0, 0, 0.75);
  box-shadow: 2px 2px 27px -20px rgba(0, 0, 0, 0.75);
}

.up {
  background: rgb(141, 151, 255);
  background: linear-gradient(
    100deg,
    rgba(141, 151, 255, 1) 9%,
    rgba(109, 202, 226, 1) 50%,
    rgba(71, 185, 255, 1) 100%
  );
  height: 10rem;
  text-align: center;
  border-radius: 1rem 1rem 0 0;
  transition-duration: 0.3s;
}

.up h2 {
  padding-top: 2rem;
  font-size: 1.2rem;
  padding-bottom: 1rem;
  color: var(--font-secondary);
}

.up p {
  font-size: 0.9rem;
  line-height: 1.4rem;
  font-weight: normal;
  color: var(--font-secondary);
}

.folder-preview {
  position: absolute;
  text-align: center;
  background-color: var(--bg);
  padding-top: 1.2rem;
  border-radius: 0.8rem;
  top: 8rem;
  left: 50%;
  transform: translateX(-50%);
  width: 7rem;
  -webkit-box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
  box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
}

.folder-preview img {
  padding-bottom: 0.6rem;
  width: 3rem;
}

.folder-preview p {
  padding-bottom: 0.5rem;
  font-size: 0.8rem;
  max-width: 6rem;
  overflow: hidden;
  text-overflow: ellipsis;
  margin: 0 auto;
  max-height: 1.5rem;
}

.down {
  background-color: var(--bg-secondary);
  height: auto;
  border-radius: 0 0 1rem 1rem;
  text-align: center;
  padding-top: 3rem;
  -webkit-box-shadow: -1px -5px 20px -9px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: -1px -5px 20px -9px rgba(0, 0, 0, 0.75);
  box-shadow: -1px -5px 20px -9px rgba(0, 0, 0, 0.75);
}

.down button {
  width: 8rem;
  border-radius: 2rem 2rem 2rem 2rem;
  border: none;
  padding-top: 1rem;
  padding-bottom: 1rem;
  cursor: pointer;
  -webkit-box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
  box-shadow: 2px 6px 13px -8px rgba(0, 0, 0, 0.75);
  margin: 1rem 0.5rem 2rem;
}

.folder-input {
  padding-left: 0.8rem;
  width: 80%;
  border: 0.1rem solid var(--brdr-el);
  transition-duration: 0.2s;
  border-radius: 2rem 2rem 2rem 2rem;
  height: 3.2rem;
  margin-top: 3.5rem;
}

.folder-submit {
  background-color: var(--btn);
  color: var(--fnt-btn);
  transition-duration: 0.2s;
}

.folder-submit:hover {
  background-color: var(--btn-hover);
  transition-duration: 0.2s;
}

.folder-submit-disabled {
  color: var(--fnt-btn);
  background-color: var(--btn-disabled);
  cursor: not-allowed !important;
}

.folder-error-alert {
  top: 57%;
  left: 50%;
  transform: translateX(-50%);
  position: absolute;
  font-size: 0.8rem;
  color: var(--fnt-err);
}

.curtains {
  height: 100vh;
  width: 100%;
  z-index: 1;
  position: absolute;
  background-color: black;
  top: 0;
  opacity: 75%;
}
.back {
  color: var(--btn);
  cursor: pointer;
  display: inline;
  font-size: 2rem;
}
</style>
