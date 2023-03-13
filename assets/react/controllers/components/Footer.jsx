import React from 'react';

const Footer = () => {
	return (
		<footer className="py-5 bg-dark text-light" id="footer">
			<div className="container">
				<div className="row justify-content-between">
					<div className="col-md-4">
						<h5 className="mb-4">Contacto</h5>
						<p>Calle de las Mariposas, 5</p>
						<p>18004 Granada</p>
						<p>958 33 33 92</p>
						<p>info@nachitorest.com</p>
					</div>
					<div className="col-md-4">
						<h5 className="mb-4">Nacho's Guacamole</h5>
						<p>Todos los derechos reservados</p>
					</div>
					<div className="col-md-4">
						<h5 className="mb-4">Nuestras redes</h5>
						<div className="d-flex justify-content-between">
							{/* <img src="img/instagram.png" alt="" className="img-fluid me-3" style={{ maxWidth: '50px' }} />
              <img src="img/facebook.png" alt="" className="img-fluid me-3" style={{ maxWidth: '50px' }} />
              <img src="img/twitter.png" alt="" className="img-fluid" style={{ maxWidth: '50px' }} /> */}
						</div>
					</div>
				</div>
			</div>
		</footer>
	);
};

export default Footer;
