<template>
  <div>
    <form class="form-container" @submit.prevent="save" v-if="!form_sent">
      <h3>Edit account information</h3>
      <div class="form-container__inner">
        <div class="form-container__inner--left">
          <h5>PERSONAL</h5>
          <div :class="{invalid: $v.information.firstname.$error}">
            <label for="firstname">First Name</label>
            <input
              type="text"
              id="firstname"
              v-model="information.firstname"
              placeholder="Enter firstname"
              @blur="$v.information.firstname.$touch()"
              required
            />
          </div>
          <div :class="{invalid: $v.information.lastname.$error}">
            <label for="lastname">Last Name</label>
            <input
              type="text"
              id="lastname"
              v-model="information.lastname"
              placeholder="Enter lastname"
              @blur="$v.information.lastname.$touch()"
              required
            />
          </div>
          <div :class="{invalid: $v.information.email.$error}">
            <label for="email">Email Address</label>
            <input
              type="mail"
              id="email"
              v-model="information.email"
              placeholder="Enter email"
              @blur="$v.information.email.$touch()"
              required
            />
          </div>
          <div :class="{invalid: $v.information.phone.$error}">
            <label for="phone">Phone</label>
            <input
              type="text"
              id="phone"
              v-model="information.phone"
              placeholder="Enter your phone number"
              @blur="$v.information.phone.$touch()"
              required
            />
          </div>
          <h5>LOCATION</h5>
          <div :class="{invalid: $v.information.country.$error}">
            <label for="country">Country</label>
            <input
              type="text"
              id="country"
              v-model="information.country"
              placeholder="Enter Country"
              @blur="$v.information.country.$touch()"
              required
            />
          </div>
          <div :class="{invalid: $v.information.city.$error}">
            <label for="city">City</label>
            <input
              type="text"
              id="city"
              v-model="information.city"
              placeholder="Enter City"
              @blur="$v.information.city.$touch()"
              required
            />
          </div>
        </div>
        <div class="form-container__inner--right">
          <h5>EDUCATION</h5>
          <div class="two-row-grid">
            <label for="education">Education</label>
            <label for="finished">Finished</label>
          </div>

          <div class="two-row-grid" v-for="(item, i) in information.educations" :key="i">
            <input type="text" class="form-control" v-model="item.education" required />
            <input type="number" class="form-control" v-model="item.finished" required />
          </div>

          <div class="circle-button" @click="add()">
            <span class="circle plus"></span>Add
          </div>

          <button class="btn" type="submit" :disabled="$v.$invalid">Save Changes</button>
        </div>
      </div>
    </form>
    <div v-if="form_sent">
      <h3>{{ response_data.firstname }} {{ response_data.lastname }}</h3>
      <p><i class="fa fa-envelope-o" aria-hidden="true" style="font-size:20px"></i> {{ response_data.email }}</p>
      <p>
        <a :href="'tel:' + response_data.phone">
          <i class="fa fa-mobile-phone" 
          aria-hidden="true" 
          style="font-size:24px">
          </i> 
          {{ response_data.phone }}
        </a>
      </p>
      <h5>LOCATION</h5>
      <p>Country: {{ response_data.country }}</p>
      <p>City: {{ response_data.city }}</p>
      <h5>EDUCATION</h5>
      <div  v-for="(item, i) in response_data.educations" :key="i">
        <p class="year">{{ item.finished}}</p>
        <p>{{ item.education }}</p>
      </div>
      <button class="edit_form" @click="editForm()">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        Edit
      </button>
    </div>
  </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      form_sent: false,
      response_data: {},
      information: {
        firstname: "",
        lastname: "",
        email: "",
        phone: "",
        country: "",
        city: "",
        educations: [
          {
            education: "",
            finished: null,
          },
        ],
      },
    };
  },
  validations: {
    information: {
      firstname: { required },
      lastname: { required },
      email: {
        required,
        email,
      },
      phone: { required },
      country: { required },
      city: { required },
      educations: {
        $each: {
          education: { required },
          finished: { required },
        },
      },
    },
  },
  methods: {
    add() {
      this.information.educations.push({
        education: "",
        finished: null,
      });
    },
    save() {
      this.form_sent = true;
      this.$http
        .post("https://factory.hr/api/test.php", this.information, {
          emulateJSON: true,
        })
        .then((res) => {
          this.response_data = res.body.post_data;
        })
        .catch((error) => console.log(error));
    },
    editForm() {
      this.form_sent = false;
    }
  },
};
</script>

<style lang="scss" scoped>
* {
  box-sizing: border-box;
}

.form-container {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin: 0 auto;
  margin-top: 30px;
  width: 70%;

  &__inner {
    display: grid;
    grid-template-columns: repeat(2, 1fr);

    label {
      display: block;
    }

    input {
      display: block;
    }

    &--left {
      input {
        margin-bottom: 10px;
        width: 90%;
        padding: 10px;
        border-radius: 0px;
        border: 1px solid lightgray;
      }
    }
    &--right {
      input {
        margin-bottom: 10px;
        width: 99%;
        padding: 10px;
        border-radius: 0px;
        border: 1px solid lightgray;
      }
    }
  }
}

.two-row-grid {
  display: grid;
  grid-template-columns: 3fr 1fr;
}

h5 {
  font-weight: 800;
}

label {
  margin-left: 10px;
  margin-bottom: 10px;
}

input:focus {
  outline: none;
  box-shadow: 0px 4px 10px rgba($color: #000000, $alpha: 0.4);
}

input:hover {
  cursor: pointer;
}

.invalid input {
  border: 1px solid red;
  background-color: #ffc9aa;
}

.invalid label {
  color: red;
}

.circle-button {
  color: #85b2ff;
  width: 70px;
  cursor: pointer;
}

.circle {
  border: 2px solid #85b2ff;
  width: 20px;
  height: 20px;
  border-radius: 100%;
  position: relative;
  margin: 4px;
  display: inline-block;
  vertical-align: middle;
}

.circle:active {
  background: #6363634f;
}
.circle:before,
.circle:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.circle.plus:before,
.circle.plus:after {
  background: #85b2ff;
}

.circle.plus:before {
  width: 2px;
  margin: 3px auto;
}

.circle.plus:after {
  margin: auto 3px;
  height: 2px;
}

.btn {
  color: white;
  background-color: #555;
  border: none;
  outline: none;
  border-radius: 100px;
  height: 45px;
  width: 150px;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 1px;
  cursor: pointer;
  float: right;
  margin-top: 75px;
}

.btn:disabled {
  background-color: #888;
  cursor: not-allowed;
}

i {
  width: 30px;
}

a {
  color: #000000;
  text-decoration: none;
}

.year {
  font-weight: bold;
}

.edit_form {
    background-color: white;
    border: none;
    outline: none;
    box-shadow: 0px 7px 10px 0px rgba(0,0,0,0.5);
    border-radius: 50px;
    height: 45px;
    width: 120px;
    margin-bottom: 100px;
    text-transform: uppercase;
    font-weight: 700;
    cursor: pointer;
}
</style>