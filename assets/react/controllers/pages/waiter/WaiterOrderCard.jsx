import React from 'react';
import { payWaiter, deliver } from '../../helpers/waiter';

function WaiterOrderCard({ order, useStateOrder, user }) {
	const { orders, setOrders } = useStateOrder;
	const classes = ['card text-light m-3 p-3 col-5'];

	if (order.status == 0) {
		classes.push('bg-warning');
	} else if (order.status == 2) {
		classes.push('bg-dark');
	}

	const orderProducts = order.products.map((product, index) => (
		<li
			key={index}
			className="bg-light text-dark list-group-item d-flex justify-content-between"
		>
			<span className="fw-bold">{product.name}</span>
			<span className="fw-bold">{product.quantity}</span>
		</li>
	));

	const handlePay = (order) => {
		payWaiter(order); // actualiza el estado en el servidor
		setOrders(orders.filter((item) => item.id != order.id)); // actualiza el estado en el cliente
	};

	const handleDeliver = (order) => {
		deliver(order, user); // actualiza el estado en el servidor
		setOrders(orders.filter((item) => item.id != order.id)); // actualiza el estado en el cliente
	};

	return (
		<article className={classes.join(' ')}>
			<header className="mb-2 text-light card-header fs-3 fw-bolder d-flex justify-content-between">
				Mesa Nº {order.table}
			</header>
			<ul className="card-content list-group">{orderProducts}</ul>
			{order.status == 0 && (
				<button
					className="mt-2 btn btn-primary"
					onClick={() => handlePay(order)}
				>
					Pagar en efectivo
				</button>
			)}
			{order.status == 2 && (
				<button
					className="mt-2 btn btn-primary"
					onClick={() => handleDeliver(order)}
				>
					Entregar
				</button>
			)}
		</article>
	);
}

export default WaiterOrderCard;
