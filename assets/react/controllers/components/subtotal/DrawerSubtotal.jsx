import React, { useState } from 'react';
import Stripe from '../stripe/Stripe';
import './DrawerSubtotal.css';

function DrawerSubtotal({
	isOpen,
	setIsDrawerOpen,
	stripeKey,
	orderId,
	orderProducts,
}) {
	const [stripe, setStripe] = useState(false);

	const handleCloseDrawer = () => {
		if (isOpen) {
			setIsDrawerOpen(false);
		}
	};

	const handleStripe = () => setStripe(!stripe);
	const handleEfectivo = () =>
		(window.location.href = `http://localhost:8000/orders/${orderId}/watch`);
	return (
		<div className={`drawer ${isOpen ? 'open' : ''}`}>
			<div className="m-4 mt-5 d-flex flex-column col-8">
				<div className="container-fluid">
					<button
						onClick={handleStripe}
						type="button"
						className="m-1 btn btn-info fw-bold"
					>
						Pago con tarjeta
					</button>
					{stripe && (
						<p className="m-1 fw-bold">
							<Stripe
								orderId={orderId}
								orderProducts={orderProducts}
								stripeKey={stripeKey}
							/>
						</p>
					)}
				</div>
				<div className="container-lg">
					<button
						onClick={handleEfectivo}
						type="button"
						className="m-1 btn btn-info fw-bold"
					>
						Pago en efectivo
					</button>
				</div>
			</div>
			<div className="col align-self-start justify-content-center">
				<button
					onClick={handleCloseDrawer}
					type="button"
					className="m-4 btn btn-outline-dark fw-bold"
				>
					<i className="far fa-times-circle"></i>
				</button>
			</div>
		</div>
	);
}

export default DrawerSubtotal;
