import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import { getProducts } from '../../helpers/kitchen';
import KitchenOrderContainer from './KitchenOrderContainer';
import './kitchen.css';
import SelectProducts from './SelectProducts';

function KitchenPage({}) {
	const [orders, setOrders] = useState([]);
	const [products, setProducts] = useState([]);

	const fetchGetOrders = async () => {
		const response = await getOrders();
		setOrders(response.filter((order) => order.status == 1));
	};

	const fetchGetProducts = async () => {
		const response = await getProducts();
		setProducts(response);
	};

	useEffect(() => {
		fetchGetProducts();
		fetchGetOrders();

		const url = JSON.parse(document.getElementById('mercure-url').textContent);
		const eventSource = new EventSource(url);

		eventSource.onmessage = (event) => {
			// Will be called every time an update is published by the server
			if (JSON.parse(event.data).status == 1) {
				fetchGetOrders();
			}
		};
	}, []);

	return (
		<main className="p-3">
			{orders.length > 0 && products.length > 0 ? (
				<>
					<SelectProducts useStateProduct={{ products, setProducts }} />
					<KitchenOrderContainer useStateOrder={{ orders, setOrders }} />
				</>
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
}

export default KitchenPage;
