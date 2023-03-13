import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import { getMenu } from '../../helpers/kitchen';
import KitchenOrderContainer from './KitchenOrderContainer';
import SelectProducts from './SelectProducts';

function KitchenPage({ user }) {
	const [orders, setOrders] = useState([]);
	const [products, setProducts] = useState([]);

	const fetchGetOrders = async () => {
		const response = await getOrders(user.restaurant);
		setOrders(response.filter((order) => order.status == 1)); // Actualiza en cliente
	};

	const fetchGetProducts = async () => {
		const response = await getMenu(user.restaurant);
		setProducts(response); // Actualiza en cliente
	};

	useEffect(() => {
		fetchGetProducts();
		fetchGetOrders();

		const url = JSON.parse(document.getElementById('mercure-url').textContent);
		const eventSource = new EventSource(url);

		eventSource.onmessage = (event) => {
			// Will be called every time an update is published to the server
			if (JSON.parse(event.data).status == 1) {
				fetchGetOrders();
			}
		};
	}, []);

	return (
		<main className="p-3">
			{orders.length > 0 && products.length > 0 ? (
				<>
					<SelectProducts
						user={user}
						useStateProduct={{ products, setProducts }}
					/>
					<KitchenOrderContainer
						user={user}
						useStateOrder={{ orders, setOrders }}
					/>
				</>
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
}

export default KitchenPage;
