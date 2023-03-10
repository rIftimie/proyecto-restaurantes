import React from 'react';
import { acceptOrder, declineOrder, finishOrder } from '../../helpers/kitchen';

function KitchenOrderCard({ order, useStateOrder }) {
	const orderStatus = order.status;
	const classes = ['card text-light my-4 w-80 mx-auto'];

	const emojis={
		'taco':'🌮',
		'pizza':'🍕',
		'nachos':'🍿',
		'burrito':'🌯',
		'hamburguer':'🍔',

	}
	const orderProducts = order.products.map(product => 
		(<>{product.name} {emojis[product.name]} - {product.quantity} <br/></>));
	// Para dar formato a la fecha que se nos da a traves de la API
	const fecha = new Date(order.orderDate.date);
	const dia = fecha.getDate();
	const mes = fecha.getMonth() + 1;
	const year = fecha.getFullYear();
	const hora = fecha.getHours();
	const minutos = fecha.getMinutes();
	const segundos = fecha.getSeconds();
	const fechaFormateada = `${dia.toString().padStart(2, "0")}-${mes.toString().padStart(2, "0")}-${year.toString()} ${hora.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}:${segundos.toString().padStart(2, "0")}`;

	if (orderStatus == 0) {
		classes.push('bg-warning');
	} else if (orderStatus == 1) {
		classes.push('bg-warning');
	} else if (orderStatus == 2) {
		classes.push('bg-success');
	} else if (orderStatus == 3) {
		classes.push('bg-primary');
	}

	async function handleAccept(order) {
		try {
			await acceptOrder(order); // actualiza el estado en el servidor
		} catch (error) {
			console.error(error);
		}
	}

	async function handleFinish(order) {
		try {
			await finishOrder(order); // actualiza el estado en el servidor
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
					<h5 className="card-title text-center fw-bolder">
						Estado del pedido: <br/><span className='orderImportant'>{order.status == 1 ? 'Esperando confirmación ⏳' : 'En preparación 🍳'}</span>
					</h5><br/>
					<div className='text-center orderImportant'>Pedido: <br/><h5 className='text-start ms-5 orderImportant'>{orderProducts}</h5></div>
					<h5 className='text-center orderMesa'>Mesa: {order.table}</h5>
					<h5 className='text-center'>Fecha: {fechaFormateada}</h5><br/>
					{order.status == 1 ? ( // Pagado
						<button
							onClick={() => handleAccept(order)}
							className="btn btn-primary mx-1 p-5"
						>
							Aceptar comanda
						</button>
					) : (
						// En Proceso
						<div className='d-flex flex-row'>
							<button
								onClick={() => handleFinish(order)}
								className="btn btn-primary mx-1 p-4 px-5"
							>
								Terminar comanda
							</button>
							<button
								onClick={() => handleDecline(order)}
								className="btn btn-primary mx-1 p-4 px-5"
							>
								Cancelar comanda
							</button>
						</div>
					)}
				</div>
			</section>
		</>
	);
}

export default KitchenOrderCard;
