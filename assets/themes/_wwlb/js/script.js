window.isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
}

!function() {
	const text_light	= "#fcfef0";
	const text_dark		= "#43454a";
	
	let header = {
		trigger		: document.querySelector('.nav-trigger-wrap'),
		navwrap		: document.querySelector('.mobile-menu-master-wrap'),
		ul			: document.getElementById('rp-mobile-navigation'),
		_click		: true,

		animate_burger: function(dir) {
			let spans = this.trigger.querySelectorAll('span');

			if ( !this._click ) return;

			//	disable click
			this._click = false;

			//	get header color scheme
			let header_color = document.body.classList.contains('nav-light') ? text_light : text_dark;

			if ( dir ) {
				//	add classes
				document.body.classList.add('mobile-nav');
				this.trigger.classList.add('active');
				this.navwrap.classList.add('active');

				let open1 = anime.timeline({
					duration : 250,
					easing : "easeOutExpo"
				});

				//	compress burger + spans color
				open1.add({
					targets : spans[0],
					translateY : [ 0, 8 ],
				}).add({
					targets : spans[2],
					translateY : [ 0, -8 ],
				}, 10).add({
					targets : spans,
					background : text_light,
					easing : "linear"
				}, 10);

				
				//	rotate to X
				anime({
					targets : this.trigger,
					rotate : "45deg",
					duration : 500,
					easing : "easeInOutExpo",
					delay : 450
				});
				anime({
					targets : spans[1],
					rotate : "90deg",
					duration : 500,
					easing : "easeInOutExpo",
					delay : 250,
					complete: () => {
						this._click = true;
						this.trigger.dataset.action = "nav-close";
					}
				});

				//	bring in navigation lis
				anime({
					targets : this.ul.children,
					opacity : [ 0, 1 ],
					translateY : [ -10, 0 ],
					duration : 750,
					easing : "easeOutExpo",
					delay : anime.stagger(100, { start : 600, from : 'center' })
				});


			} else {
				//	navigation lis out
				anime({
					targets : this.ul.children,
					opacity : [ 1, 0 ],
					translateY : [ 0, -10 ],
					duration : 250,
					easing : "easeInExpo",
					delay : anime.stagger(35, { from : 'last' })
				});

				//	rotate to burger
				anime({
					targets : spans[1],
					rotate : [ "90deg", 0 ],
					duration : 250,
					easing : "easeOutExpo",
					complete : function() {
						//	remove classes
						document.body.classList.remove('mobile-nav');
					}
				});
				anime({
					targets : this.trigger,
					rotate : [ "45deg", 0 ],
					duration : 750,
					easing : "easeInOutExpo"
				});

				//	spans color
				anime({
					targets : spans,
					background : header_color,
					duration : 250,
					delay : 500,
					easing : "linear"
				});

				//	restore burger
				anime({
					targets : spans[0],
					translateY : [ "8px", 0 ],
					duration : 400,
					easing : "easeOutExpo",
					delay : 350
				});
				anime({
					targets : spans[2],
					translateY : [ "-8px", 0 ],
					duration : 400,
					easing : "easeOutExpo",
					delay : 350,
					complete: () => {
						this._click = true;
						this.trigger.dataset.action = "nav-open";

						//	remove classes
						setTimeout(() => { 
							this.trigger.classList.remove('active');
							this.navwrap.classList.remove('active');
						}, 500);
					}
				});
			}
		}
	};




	document.addEventListener('click', function(e) {
		//	mobile nav
		if ( e.target.dataset.action === "nav-open" ) {
			header.animate_burger(true);
		}
		if ( e.target.dataset.action === "nav-close" ) {
			header.animate_burger(false);
		}

	});


	window.addEventListener('resize', function(e) {

	});
	
}();