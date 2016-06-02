<template>
	<aside class="menu">
		<p class="menu-label">
	    	User's Name
	  	</p>
	  	<ul class="menu-list">
	    	<li><a>Reports</a></li>
	  	</ul>
	  	<p class="menu-label">
	    	Administration
	  	</p>
	  	<ul class="menu-list">
	    	<li><a v-link="{ path: '/sections', activeClass: 'is-active'}">Sections</a></li>
	    	<li><a v-link="{ path: '/semesters', activeClass: 'is-active'}">Semesters</a></li>
	    	<li><a v-link="{ path: '/users', activeClass: 'is-active'}">Users</a></li>
	  	</ul>
	</aside>
</template>
