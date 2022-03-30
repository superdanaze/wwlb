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
	const text_light	= "#fafafa";
	const text_dark		= "#222";
	
	let header = {
		trigger		: document.querySelector('.nav-trigger-wrap'),
		navwrap		: document.querySelector('.mobile-menu-master-wrap'),
		ul			: document.getElementById('ela-mobile-navigation'),
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
						this.navwrap.classList.remove('active');
						setTimeout(() => { 
							this.trigger.classList.remove('active');
						}, 500);
					}
				});
			}
		}
	};


	let wwlbui = {
		home_blocks			: document.querySelectorAll('.home-synopsis-block'),

		init: function() {
			//	home synopsis blocks
			this.activate_blocks();
		},

		activate_blocks: function(init = false) {
			const accents = new IntersectionObserver((entries) => {
				entries.forEach( entry => {
					entry.isIntersecting ? entry.target.classList.add('accent') : entry.target.classList.remove('accent');
				});
			},{
				threshold : 0.25
			});

			const frame = new IntersectionObserver((entries) => {
				entries.forEach( entry => {
					entry.isIntersecting ? entry.target.classList.add('active') : entry.target.classList.remove('active');
				});
			},{
				threshold : 0.5
			});

			const block_text = new IntersectionObserver((entries) => {
				entries.forEach( entry => {
					entry.target.classList.toggle('_active', entry.isIntersecting);

					//	fade in spans
					this.fade_spans( entry.target, entry.isIntersecting );
				});
			},{
				threshold : 0.5
			});

			this.home_blocks.forEach( b => {
				let text = b.querySelectorAll(".synopsis");
				
				//	blocks
				frame.observe( b );

				//	accents
				accents.observe( b );

				//	text
				text.forEach( t => block_text.observe( t ) );
			});
		},

		fade_spans: function(container, state) {
			let spans = container.querySelectorAll('span.__fade'),
				delay = 1000,
				duration = 750;
			
			let anim = anime.timeline({
				targets : spans,
				duration : duration,
				easing : "easeInOutCubic",
			});

			if ( spans && state && !container.classList.contains('complete') ) {
				container.classList.add('complete');
				
				anim.add({
					opacity : 1,
					delay : function(el, i ,l) {
						return (delay * i) + delay;
					}
				});
			} 
		}
	};

	//	init wwlb ui items
	wwlbui.init();


	let lang_select = {
		selector		: document.querySelector('.lang-select'),
		_click			: 0,

		init: function() {
			this.selector.addEventListener('click', (e) => {
				//	activate language
				this.activate(e);

				//	execute language dependent actions
				// this.execute();
			});

			//	reset click & button for mobile
			if ( window.isMobile.any() ) {
				document.addEventListener('click', (e) => {
					if ( !e.target.classList.contains('lang-select') ) {
						this._click = 0;
						this.selector.classList.remove('active');
					}
				});
			}
		},

		activate: function(e) {
			let body = document.body.classList;

			if ( window.isMobile.any() ) {
				if ( this._click === 0 ) {
					this._click = 1;
					this.selector.classList.add('active');
				} else if ( this._click === 1 ) {
					if ( body.contains('lang-en') ) {
						body.remove('lang-en');
						body.add('lang-es');

						document.body.dataset.lang = 'esp';
					} else if ( body.contains('lang-es') ) {
						body.remove('lang-es');
						body.add('lang-en');

						document.body.dataset.lang = 'eng';
					}

					// //	reset click & button
					// this._click = 0;
					// this.selector.classList.remove('active');
				}
			} else {
				if ( body.contains('lang-en') ) {
					body.remove('lang-en');
					body.add('lang-es');

					document.body.dataset.lang = 'esp';
				} else if ( body.contains('lang-es') ) {
					body.remove('lang-es');
					body.add('lang-en');

					document.body.dataset.lang = 'eng';
				}
			}
		},

		execute: function() {
			//	make sure sliding image(s) are targeting correct image
			if ( sliding_hero.wrap ) sliding_hero.set_active_img();
			
		}
	};

	//	init
	lang_select.init();


	let sliding_hero = {
		wrap		: document.querySelector('.sliding-hero-wrap'),
		// img			: document.querySelector('.sliding-hero-wrap').querySelector('img'),
		// text		: document.querySelector('.sliding-text-wrap'),

		init: function() {
			//	define vars
			this.img = this.wrap.querySelector('img');
			this.text = document.querySelector('.sliding-text-wrap');

			//	set the height of the wrapper
			this.setHeight();
		},

		setHeight: function() {
			let wh = window.innerHeight,
				ih = this.img.offsetHeight;

			if ( wh * 1.25 > ih ) {
				this.wrap.style.height = ih + "px";
			} else {
				this.wrap.style.height = wh * 1.25 + "px";
			}
		},

		set_active_img: function() {
			let key = document.body.dataset.lang;
			if ( this.wrap ) this.img = this.wrap.querySelector(`.${key} img`);
		},

		scroll_img: function(e) {
			let bottom = this.wrap.getBoundingClientRect().bottom,
				diff = this.img.offsetHeight - this.wrap.offsetHeight,
				travel = (window.innerHeight * 1.25) - (window.innerHeight / 2),
				Y = window.pageYOffset;

			if ( this.img.offsetHeight > window.innerHeight && bottom > (window.innerHeight / 2) ) {
				//	scroll image
				anime({
					targets : this.img,
					translateY : -((diff / travel) * Y),
					duration : 150,
					easing : "easeOutQuad"
				});

				//	scroll text
				this.scroll_text( travel, Y );
			} else if ( this.img.offsetHeight > window.innerHeight && bottom <= (window.innerHeight / 2) ) {

				//	if scrolled past midway point of viewport
				this.img.style.transform = `translateY(-${diff}px)`;
				this.scroll_text( travel, Y, false );
			}
		},

		scroll_text: function( travel, Y, scroll = true ) {
			let diff = 100;

			if ( scroll ) {
				anime({
					targets : this.text,
					translateY : -((diff / travel) * Y),
					duration : 150,
					easing : "easeOutQuad"
				});
			} else {
				this.text.style.transform = `translateY(-${diff}px)`;
			}
			
		}
	};

	//	init sliding hero items
	// if ( sliding_hero.wrap ) sliding_hero.init();


	let trailer = {
		wrap		: document.querySelector('.ela-trailer-wrap'),
		iframe		: document.querySelector('.ela-trailer-wrap').querySelector('iframe'),
		isActive	: false,

		modal: function(state) {
			if ( state === "trailer-open" ) {
				anime({
					targets : this.wrap,
					opacity : 1,
					duration : 1000,
					easing : 'linear',
					begin : () => {
						this.wrap.classList.remove('hide');

						//	init trailer url
						this.iframe.src = this.iframe.dataset.src;
						
						//	set active
						this.isActive = true;
					}
				});

			} else if ( state === "trailer-close" ) {
				anime({
					targets : this.wrap,
					opacity : 0,
					duration : 750,
					easing : 'linear',
					complete : () => {
						this.wrap.classList.add('hide');

						//	reset trailer url
						this.iframe.src = "";

						//	set active
						this.isActive = true;
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

		//	trailer modal
		if ( trailer.wrap && ( e.target.dataset.action || e.target.rel === "trailer-open" || e.target.hash === "#play-trailer") ) {
			e.preventDefault();

			let d = undefined;
				if (e.target.hash) d = "trailer-open";
				if ( d === undefined ) d = e.target.dataset.action ? e.target.dataset.action : e.target.rel;
				 
			trailer.modal(d);
		}

	});

	// window.addEventListener('scroll', function(e) {
	// 	if ( sliding_hero.wrap ) sliding_hero.scroll_img(e);
	// });


	// window.addEventListener('resize', function(e) {
	// 	//	set height of sliding hero 
	// 	if ( sliding_hero.wrap ) sliding_hero.setHeight();
	// });

	document.addEventListener('keyup', function(e) {
		//	trailer - escape to close
		if ( trailer.isActive && ( e.key === "Escape" || e.which === 27 ) ) trailer.modal( 'trailer-close' );
	});
	
}();