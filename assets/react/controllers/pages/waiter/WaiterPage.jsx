import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import WaiterOrderContainer from './WaiterOrderContainer';

function WaiterPage() {
	const [orders, setOrders] = useState([]);

	const fetchGetOrders = async () => {
		const response = await getOrders();
		setOrders(
			response.filter((order) => order.status == 0 || order.status == 2)
		);
	};

	useEffect(() => {
		fetchGetOrders();

		const url = JSON.parse(document.getElementById('mercure-url').textContent);
		const eventSource = new EventSource(url);

		eventSource.onmessage = (event) => {
			// Will be called every time an update is published by the server
			if (
				JSON.parse(event.data).status == 0 ||
				JSON.parse(event.data).status == 2
			) {
				fetchGetOrders();
			}
		};
	}, []);

	return (
		<main>
			{orders.length > 0 ? (
				<WaiterOrderContainer useStateOrder={{ orders, setOrders }} />
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
}

export default WaiterPage;
