import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import KitchenOrderContainer from './KitchenOrderContainer';
import './kitchen.css';

function KitchenPage() {
	const [orders, setOrders] = useState([]);
	const fetchGetOrders = async () => {
		const response = await getOrders();
		setOrders(
			response.filter((order) => order.status == 1 || order.status == 2)
		);
	};

	useEffect(() => {
		fetchGetOrders();
	}, []);

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
