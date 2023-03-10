import React, { useEffect, useState } from 'react';
import { getOrders } from '../../helpers/orders';
import OrderWaiterContainer from './OrderWaiterContainer';

function WaiterPage() {
	const [orders, setOrders] = useState([]);
	const fetchGetOrders = async () => {
		const response = await getOrders();
		setOrders(
			response.filter((order) => order.status == 0 || order.status == 3)
		);
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
