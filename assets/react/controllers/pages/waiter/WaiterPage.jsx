import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import OrderWaiterContainer from './OrderWaiterContainer';

function WaiterPage() {
	const url = JSON.parse(document.getElementById('mercure-url').textContent);
	const eventSource = new EventSource(url);

	const [orders, setOrders] = useState([]);

	const fetchGetOrders = async () => {
		console.log('fetch');
		const response = await getOrders();
		setOrders(
			response.filter((order) => order.status == 0 || order.status == 3)
		);
	};

	function handleEvent(order) {
		console.log('Orders', orders);
		console.log('order', order);
		if (order.status == 0 || order.status == 3) {
			if (orders.map((item) => item.id).includes(order.id)) {
				console.log('update');
				setOrders(
					orders.map((item) => {
						if (item.id == order.id) {
							item = order;
						}
						return item;
					})
				);
			} else {
				console.log('new');
				setOrders(orders.concat(order));
			}
		}
	}

	eventSource.onmessage = (event) => {
		// Will be called every time an update is published by the server
		handleEvent(JSON.parse(event.data));
	};

	useEffect(() => {
		fetchGetOrders();
	}, []);

	return (
		<main>
			<h1 className="text-center">CAMARERO</h1>
			{orders.length > 0 ? (
				<OrderWaiterContainer useStateOrder={{ orders, setOrders }} />
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
}

export default WaiterPage;
