import React from 'react';
import { declineOrder, finishOrder } from '../../helpers/kitchen';

function KitchenOrderCard({ order, useStateOrder, user }) {
	const { orders, setOrders } = useStateOrder;
	const classes = [
		'card text-light m-3 p-3 col-12 col-md-5 col-xl-3 bg-warning',
	];

	const orderProducts = order.products.map((product, index) => (
		<li
			key={index}
			className="bg-dark text-light list-group-item d-flex justify-content-between"
		>
			<span>{product.name}</span>
			<span>{product.quantity}</span>
		</li>
	));

	// Formateo de la fecha eliminando los segundos
	let fecha = order.orderDate.date.toString().split(':');
	fecha.pop();
	fecha = fecha.join(':');

	// Marcar pedido como realizado
	async function handleFinish(order) {
		try {
			await finishOrder(order, user); // actualiza el estado en el servidor
			setOrders(orders.filter((item) => item.id != order.id));
		} catch (error) {
			console.error(error);
		}
	}

	// Cancelar pedido
	async function handleDecline(order) {
		try {
			await declineOrder(order, user); // actualiza el estado en el servidor
			useStateOrder.setOrders(
				useStateOrder.orders.filter((item) => order != item)
			); // actualiza el estado en el cliente
		} catch (error) {
			console.error(error);
		}
	}

	return (
		<>
			<article className={classes.join(' ')}>
				<header className="mb-2 text-dark card-header fs-3 fw-bolder d-flex justify-content-between">
					Mesa Nº {order.table}
				</header>
				<ul className="card-content list-group">{orderProducts}</ul>
				<h5 className="text-end">{fecha}</h5>
				<button
					onClick={() => handleFinish(order)}
					className="p-3 mx-1 mt-2 btn btn-primary"
				>
					Terminar comanda
				</button>
			</article>
		</>
	);
}

export default KitchenOrderCard;
