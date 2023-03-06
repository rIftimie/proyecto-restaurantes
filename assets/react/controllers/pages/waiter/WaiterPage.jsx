import React, { useEffect, useState } from 'react';
import { getOrders } from '../../api/orders';

import OrderWaiterContainer from './OrderWaiterContainer';

function WaiterPage() {
	const [orders, setOrders] = useState([]);
	useEffect(() => {
		getOrders().then((json) => setOrders(json));
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
