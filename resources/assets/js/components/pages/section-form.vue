<template>
  <h1 class="title">Add a section</h1>
  <article class="message is-primary">
  <div class="message-header">
    Section Form
  </div>
  <div class="message-body">
  	<div class="columns">
	  <div class="column is-half">
		<p class="control">
	      <input class="input" v-model="section.crn" type="text" placeholder="CRN">
	    </p>
	    <p class="control">
	      <input class="input" v-model="section.course_code" type="text" placeholder="Course Code">
	    </p>
	    <p class="control">
	      <input class="input" v-model="section.course_title" type="text" placeholder="Course Title">
	    </p>
	    <p class="control">
	      <input class="input" v-model="section.class_time" type="text" placeholder="Class Time">
	    </p>
	    <p class="control">
	      <input class="input" v-model="section.location" type="text" placeholder="Location">
	    </p>
	    <p class="control">
	      <input class="input" v-model="section.enrolled" type="text" placeholder="Enrolled">
	    </p>
	    <p class="control">
		  <button @click="add" class="button is-primary">Submit</button>
		  <button v-link="'/sections'" class="button is-danger">Cancel</button>
		</p>
	  </div>
	  <div class="column is-half">
	   <p class="control">
		  <button class="button is-disabled">{{ section.status }}</button>
		</p>
	    <p class="control">
	      <span class="select">
		    <select v-model="section.semester_id">
		      <option v-for="semester in semesters" v-bind:value="semester.id">
		      	{{ semester.season }} {{ semester.year }}
		      </option>
		    </select>
          </span>
	    </p>
	    <p class="control">
	      <span class="select">
		    <select v-model="section.school_id">
		      <option>Select School</option>
		      <option v-for="school in schools" v-bind:value="school.id">
		      	{{ school.school }}
		      </option>
		    </select>
          </span>
	    </p>
	    <p class="control">
	      <span>
		    <select multiple>
		      <option v-for="user in users">
		      	{{ user.name }}
		      </option>
		    </select>
          </span>
	    </p>

	  </div>
	 </div>
  </div>
</article>
</template>
<script>
	import semesterStore from '../../stores/semester';
	import schoolStore from '../../stores/school';
	import userStore from '../../stores/user';
	import sectionStore from '../../stores/section';

	export default {
		data() {
			return {
				section: {
					status: "Locked",
				},
				semesters: {},
				users: {},
				schools: {},
			};
		},
		ready() {
			semesterStore.getAllSemesters(this.getSemesters);
			schoolStore.getAllSchools(this.getSchools);
			userStore.getAllUsers(this.getUsers);
		},
		methods: {
			getSemesters(res) {
				this.semesters = res.data;
			},
			getSchools(res) {
				this.schools = res.data;
			},
			getUsers(res) {
				this.users = res.data;
			},
			add() {
				sectionStore.addSection(this.section, this.added);
			},
			added(res) {
				console.log('Section added');
				console.log(res);
				this.$router.go('/sections');
			}
		},
	}
</script>