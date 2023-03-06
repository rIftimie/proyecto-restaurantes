import React, { useEffect, useState } from 'react';
import { getOrders } from '../../api/orders';
import KitchenOrderContainer from './KitchenOrderContainer';

const KitchenPage = () => {
	const [orders, setOrders] = useState([]);
	const fetchGetOrders = async () => {
		try {
			const response = await getOrders();
			setOrders(
				response.filter(
					(order) => order.status == 1 || order.status == 2
				)
			);
		} catch (error) {
			console.log(error);
		}
	};

	useEffect(() => {
		fetchGetOrders();
	}, []);

	return (
		<main>
			<h1 className="text-center">COCINA</h1>
			{orders.length > 0 ? (
				<KitchenOrderContainer useStateOrder={{ orders, setOrders }} />
			) : (
				<h1>Loading ...</h1>
			)}
		</main>
	);
};

export default KitchenPage;
