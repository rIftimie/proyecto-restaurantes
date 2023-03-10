import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import KitchenOrderContainer from './KitchenOrderContainer';
import './kitchen.css';

function KitchenPage() {
	const url = JSON.parse(document.getElementById('mercure-url').textContent);
	const eventSource = new EventSource(url);

	const [orders, setOrders] = useState([]);

	const fetchGetOrders = async () => {
		console.log('fetch');
		const response = await getOrders();
		setOrders(
			response.filter((order) => order.status == 1 || order.status == 2)
		);
	};

	useEffect(() => {
		fetchGetOrders();

		eventSource.onmessage = (event) => {
			// Will be called every time an update is published by the server
			console.log('Orders', orders);
			if (
				JSON.parse(event.data).status == 1 ||
				JSON.parse(event.data).status == 2
			) {
				handleEvent(JSON.parse(event.data));
			} else if (
				orders
					.map((item) => item.id)
					.includes(JSON.parse(event.data).id)
			) {
				setOrders(
					orders.filter(
						(item) => item.status == 1 || item.status == 2
					)
				);
			}
		};
	}, []);

	function handleEvent(order) {
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
			console.log(order.status);
			setOrders(orders.concat(order));
		}
	}

	return (
		<main>
			<h1 className="text-center title m-4 fw-bolder">COCINA</h1>
			{orders.length > 0 ? (
				<KitchenOrderContainer useStateOrder={{ orders, setOrders }} />
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
}

export default KitchenPage;
