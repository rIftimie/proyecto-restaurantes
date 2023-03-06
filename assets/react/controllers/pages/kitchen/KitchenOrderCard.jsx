import React from 'react';
import { acceptOrder, declineOrder, finishOrder } from '../../helpers/kitchen';

function KitchenOrderCard({ order, useStateOrder }) {
	const orderStatus = order.status;
	const classes = ['card text-light d-flex'];

	if (orderStatus == 0) {
		classes.push('bg-warning');
	} else if (orderStatus == 1) {
		classes.push('bg-success');
	} else if (orderStatus == 2) {
		classes.push('bg-warning');
	} else if (orderStatus == 3) {
		classes.push('bg-primary');
	}

	async function handleAccept(order) {
		try {
			await acceptOrder(order); // actualiza el estado en el servidor
			useStateOrder.setOrders(
				useStateOrder.orders.map((item) =>
					order.id == item.id ? { ...item, status: 2 } : item
				)
			); // actualiza el estado en el cliente
		} catch (error) {
			console.error(error);
		}
	}

	async function handleFinish(order) {
		try {
			await finishOrder(order); // actualiza el estado en el servidor
			useStateOrder.setOrders(
				useStateOrder.orders.filter((item) => order != item)
			); // actualiza el estado en el cliente
		} catch (error) {
			console.error(error);
		}
	}

	async function handleDecline(order) {
		try {
			await declineOrder(order); // actualiza el estado en el servidor
			useStateOrder.setOrders(
				useStateOrder.orders.filter((item) => order != item)
			); // actualiza el estado en el cliente
		} catch (error) {
			console.error(error);
		}
	}

	return (
		<>
			<section
				className={classes.join(' ')}
				style={{ textAlign: 'center' }}
			>
				<div className="card-body">
					<p>Camarero:{order.waiter}</p>
					<h5 className="card-title">
						Estado del pedido:
						{order.status == 1 ? 'En confirmación' : 'Trabajando'}
					</h5>
					<h6>Fecha:{order.orderDate.date}</h6>

					{order.status == 1 ? ( // Pagado
						<button
							onClick={() => handleAccept(order)}
							className="btn btn-primary"
						>
							Aceptar orden
						</button>
					) : (
						// En Proceso
						<>
							<button
								onClick={() => handleFinish(order)}
								className="btn btn-primary"
							>
								Terminar orden
							</button>
							<button
								onClick={() => handleDecline(order)}
								className="btn btn-primary"
							>
								Cancelar orden
							</button>
						</>
					)}
				</div>
			</section>
		</>
	);
}

export default KitchenOrderCard;
