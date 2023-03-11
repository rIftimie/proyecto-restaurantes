import React from 'react';
import { payWaiter, deliver } from '../../helpers/waiter';

function OrderWaiterCard({ order, useStateOrder }) {
	const orderStatus = order.status;
	let msgStatus;
	const classes = ['card text-light d-flex'];

	if (orderStatus == 0) {
		classes.push('bg-warning');
	} else if (orderStatus == 1) {
		classes.push('bg-success');
	} else if (orderStatus == 2) {
		classes.push('bg-danger');
	} else if (orderStatus == 3) {
		classes.push('bg-secondary');
	} else if (orderStatus == 4) {
		classes.push('bg-dark');
	}

	switch (order.status) {
		case 0:
			msgStatus = 'Pendiente de pago';
			break;
		case 3:
			msgStatus = 'Listo';
			break;
		default:
			msgStatus = 'Estado desconocido';
			break;
	}

	const handlePay = (orderId) => {
		payWaiter(order); // actualiza el estado en el servidor

		const updatedOrders = useStateOrder.orders.map((order) =>
			order.id === orderId ? { ...order, status: 1 } : order
		);

		useStateOrder.setOrders(updatedOrders); // actualiza el estado en el cliente
	};

	const handleDeliver = (orderId) => {
		deliver(order); // actualiza el estado en el servidor

		const updatedOrders = useStateOrder.orders.map((order) =>
			order.id === orderId ? { ...order, status: 4 } : order
		);

		useStateOrder.setOrders(updatedOrders); // actualiza el estado en el cliente
	};

	return (
		<section className={classes.join(' ')} style={{ textAlign: 'center' }}>
			<div className="card-body">
				<p>Camarero:{order.waiter}</p>
				<h5 className="card-title">Estado del pedido:{msgStatus}</h5>

				{orderStatus == 0 && (
					<button
						className="btn btn-primary"
						onClick={() => handlePay(order.id)}
					>
						Pagar en efectivo
					</button>
				)}
				{orderStatus == 3 && (
					<button
						className="btn btn-primary"
						onClick={() => handleDeliver(order.id)}
					>
						Entregar
					</button>
				)}
			</div>
		</section>
	);
}

export default OrderWaiterCard;
