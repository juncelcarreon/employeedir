@extends('layouts.main')
@section('title')
<?= ($dashboard) ? 'Dashboard' : 'Home' ?>
@endsection
@section('content')
<style>
.home-title{
	font-weight: bold !important;
	margin: 0 auto 10px !important;
}

.panel-announcement{
	padding: 0 !important;
	background: unset !important;
	box-shadow: none !important;
}

.emp-image{
	width: 50px;
	height: 50px;
	margin-top: -10px;
}

.emp-image img{
	width: 100%;
	height: 100%;
	box-shadow: 1px 1px 10px 7px #fff;
	border-radius: 50%;
	object-fit: cover;
	object-position:50% 50%;
	transform: translateZ(0);
}

.timeline:before{
	display: none;
}

.timeline-title{
	font-weight: 400 !important;
}

.timeline-title a, .birthday-holder a{
	transition: linear 0.3s;
}

.timeline-title a:hover, .birthday-holder a:hover{
	padding-left: 5px;
}

.birthday-title{
	font-weight: 600;
	font-size: 16px;
	text-align: center;
	padding: 11px;
	font-family: cursive;
}

.birthday-img{
	width: 50px;
	height: 50px;
	margin-right: 15px;
	float: left;
}

.birthday-img img{
	width: 100%;
	height: 100%;
	border-radius: 50%;
	object-fit: cover;
	object-position:50% 50%;
	transform: translateZ(0);
}

.engagement{
	cursor: pointer;
	margin: 10px auto;
	border-bottom: 1px solid #ccc;
	padding: 10px;
}

.engagement img{
	width: 100%;
}

.engagement:hover{
	color: #30A5FF;
}

.engagement:last-child{
	border: 0;
}
</style>
<?php
if(count($posts) > 0) {
?>
<div class="col-md-12">
	<h3 class="home-title">Announcement</h3>
</div>
<div class="col-md-12">
	<div class="panel panel-container panel-announcement">
		<div class="row">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
				<?php
				foreach($posts as $idx=>$post) {
				?>
					<li data-target="#myCarousel" data-slide-to="<?= $idx ?>"<?= ($idx == 0) ? ' class="active"' : '' ?>></li>
				<?php
				}
				?>
				</ol>
				<div class="carousel-inner">
				<?php
				foreach($posts as $idx=>$post) {
				?>
					<div class="item<?= ($idx == 0) ? ' active' : '' ?>">
						<img class="img-thumbnail" src="<?= $post->image ?>" alt="post<?=$post->id ?>">
					</div>
				<?php
				}
				?>
				</div>
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Mission

				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body timeline-container">
				<p>To provide our employees the career growth opportunities they aspire, and our customers the facilities, technologies, and services they deserve.</p>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Vision

				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body timeline-container">
				<p>To become the premier vendor of choice for advanced, standardized, and world-class outsourcing solutions.</p>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				New Hires

				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body timeline-container">
				<ul class="timeline">
				<?php
				foreach($new_hires as $employee) {
				?>
					<li class="new_hires_div">
						<div class="timeline-badge">
							<div class="emp-image">
								<img src="<?= $employee->profile_img ?>" alt="<?= $employee->fullname() ?>">
							</div>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
							<?php
							if(Auth::check() && Auth::user()->isAdmin()) {
							?>
								<h4 class="timeline-title name-format"><a href="employee_info/<?= $employee->id ?>"><?= $employee->fullname() ?></a></h4>
							<?php
							} else {
							?>
								<h4 class="timeline-title name-format"><?= $employee->fullname() ?></h4>
							<?php
							}
							?>
							</div>
							<div class="timeline-body">
								<p><?= joinGrammar($employee->prod_date) ?> the <?= $employee->team_name ?> as <?= $employee->position_name ?></p>
							</div>
							<div class="timeline-body">
								<small><?= $employee->prettyprodDate() ?></small>
							</div>
						</div>
					</li>
				<?php
				}
				if(count($new_hires) == 0) {
				?>
					<div class="text-center">No employees so far</div>
				<?php
				} else {
				?>
					<div class="text-center">
						<br>
						<br>
						<span class="fa fa-spinner" id="new_hire_loader"></span>
						<br>
						<br>
						<button class="btn" type="button" id="more_new_hires">
							<span class="fa fa-arrow-down"></span>&nbsp;&nbsp;View More
						</button>
					</div>
				<?php
				}
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Birthday Celebrants for <?= date('F') ?>

				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body timeline-container">
			<?php
			if(count($birthdays) > 0) {
				$current = [];
				$celebrants = [];
				foreach($birthdays as $key=>$celebrant) {
					if(date('m-d', strtotime($celebrant->birth_date)) == date('m-d')){
						$current[$key] = $celebrant;
					} else {
						$celebrants[$key] = $celebrant;
					}
				}
				if(count($current) > 0) {
			?>
				<h4 class="birthday-title">Today's Celebrants</h4>
				<br>
				<div class="birthday-celebrants-div">
			<?php
				foreach($current as $celebrant) {
			?>
					<div class="birthday-holder">
						<div class="birthday-img">
							<img src="<?= $celebrant->profile_img ?>" alt="<?= $employee->fullname() ?>">
						</div>
						<p class="name-format">
					<?php
						if(Auth::check() && Auth::user()->isAdmin()) {
					?>
							<a href="<?= url("employee_info/{$celebrant->id}") ?>"><?= $celebrant->fullname() ?></a>
						<?php
						} else {
							echo $celebrant->fullname();
						}
					?>
							<br>
							<span>
								<span class="fa fa-gift"></span>
								<?= monthDay($celebrant->birth_date) ?>
							</span>
						</p>
					</div>
			<?php
				}
			?>
				</div>
			<?php
			}
			?>
				<h4 class="birthday-title"><?= (count($current) > 0) ? '...' : date('F') ?></h4>
				<br>
				<div class="birthday-celebrants-div">
			<?php
				foreach($celebrants as $celebrant) {
			?>
					<div class="birthday-holder">
						<div class="birthday-img">
							<img src="<?= $celebrant->profile_img ?>" alt="<?= $employee->fullname() ?>">
						</div>
						<p class="name-format">
					<?php
						if(Auth::check() && Auth::user()->isAdmin()) {
					?>
							<a href="<?= url("employee_info/{$celebrant->id}") ?>"><?= $celebrant->fullname() ?></a>
						<?php
					} else {
						echo $celebrant->fullname();
					}
						?>
							<br>
							<span>
								<span class="fa fa-gift"></span>
								<?= monthDay($celebrant->birth_date) ?>
							</span>
						</p>
					</div>
			<?php
				}
			?>
				</div>
			<?php
			} else {
			?>
				<div class="text-center">
					<br>
					<span class="fa fa-birthday-cake fa-xl"></span>
					<br>
					<br>
					No birthday celebrant for <?= date('F') ?>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				eLinkgagement Activities

				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body timeline-container">
			<?php
			foreach($engagements as $engagement) {
			?>
				<div class="text-center engagement" data-img="<?= $engagement->image_url ?>">
					<b class="engagement_title"><?= $engagement->title ?></b>
					<br>
					<small class="engagement_title"><?= $engagement->subtitle ?></small>
					<br>
					<br>
				<?php
				if(isset($engagement->image_url) || $engagement->image_url != "") {
					if(pathinfo($engagement->image_url, PATHINFO_EXTENSION) == "mp4") {
				?>
					<video width="320" height="240" controls>
						<source src="<?= $engagement->image_url ?>" type="video/mp4">
						<source src="<?= $engagement->image_url ?>" type="video/ogg">
						Your browser does not support the video tag.
					</video>
				<?php
					} else {
				?>
					<img class="engagement_title" src="<?= $engagement->image_url ?>" alt="<?= $engagement->title ?>">
				<?php
					}
				?>
					<br>
					<br>
				<?php
				}
				?>
					<p><?= $engagement->message ?></p>
					<small><?= monthDay($engagement->activity_date) ?></small>
				</div>
			<?php
			}
			if(count($engagements) == 0) {
			?>
				<div class="text-center">No events yet</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<button class="pull-right" id="backtotop">
		<span class="fa fa-lg fa-arrow-up"></span>&nbsp;Back to top
	</button>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
var current_page = 2;
$(function() {
	activeMenu($('#menu-home'));

	$('#new_hire_loader').hide();

	$('#more_new_hires').click(function(){
		$('#new_hire_loader').show();
		$('#more_new_hires').hide();
		$.ajax({
			url: "{{url('newhires')}}" + "?page=" + current_page,
			success: function(result){
				setTimeout(function(){
					$('#new_hire_loader').hide();
					$('#more_new_hires').show();
					result.data.forEach(function(employee) {
						var new_hires_div = '<li class="new_hires_div">';
							new_hires_div += '<div class="timeline-badge">';
							new_hires_div += '<div class="emp-image">';
							new_hires_div += '<img src="' + employee.profile_img +'" alt="'+ employee.last_name + ', ' + employee.first_name +'"></div></div>';
							new_hires_div += '<div class="timeline-panel">';
							new_hires_div += '<div class="timeline-heading">';
						<?php
						if(Auth::check() && Auth::user()->isAdmin()) {
						?>
							new_hires_div += ' <h4 class="timeline-title name-format"><a href="profile/' + employee.id + '">'+ employee.last_name + ', ' + employee.first_name +'</a></h4>';
						<?php
						} else {
						?>
							new_hires_div += ' <h4 class="timeline-title name-format">'+ employee.last_name + ', ' + employee.first_name +'</h4>';
						<?php
						}
						?>
							new_hires_div += '</div>';
							new_hires_div += '<div class="timeline-body">';
							new_hires_div += '<p>' + joinGrammar(employee.prod_date) + ' the ' + employee.team_name + ' as ' + employee.position_name + '</p>';
							new_hires_div += '</div>';
							new_hires_div += '<div class="timeline-body">';
							new_hires_div += '<small>' + timeConverter(employee.prod_date ) + '</small>';
							new_hires_div += "</div>";
							new_hires_div += "</div>";
							new_hires_div += "</li>";

						$('.new_hires_div:last-of-type').after(new_hires_div);
					});
				}, 1500);
				current_page++;
			}, error: function(){
				$('#new_hire_loader').hide(); 
				$('#more_new_hires').show();
			}
		});
	});

	$('#backtotop').click(function(){
		$("html, body").animate({
			scrollTop: 0
		}, 300); 
	});

	$('.engagement').click(function(e){
		e.preventDefault();

		window.open($(this).data('img'));
	});
});
</script>
@endsection