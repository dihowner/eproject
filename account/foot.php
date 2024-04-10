
					
                    <footer class="footer" style="background: #000">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="color: #fff; font-size: 18px">
                                    2017 - 2020 &copy; Simple theme by <a href="#">Coderthemes</a>
                                </div>
                            </div>
                        </div>
                    </footer>
					
					<script>
						function logOff(ev) {
							
							ev.preventDefault();
					
							var urlToRedirect = ev.currentTarget.getAttribute('href');
							
							swal.fire({
								icon: "info",
								html: "You are about to sign out of your account. Hope to see you soon",
								buttons: true,
								dangerMode: true,
								allowOutsideClick: false,
								showCancelButton: true,
								confirmButtonText: "<b><i class='ti-power-off'></i> Sign Me Out</b>",
								cancelButtonText: "<b>Not Now"
								
							}).then((isRedirect) => {
						
								if(isRedirect.isConfirmed) {
									
									window.location = urlToRedirect;
								} else { 
									//Show or Do Nothing... 
								}
							});
						}
					</script>