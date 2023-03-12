import React from 'react';
import WaiterOrderCard from './WaiterOrderCard';

function WaiterOrderContainer({ useStateOrder }) {
	const { orders } = useStateOrder;

	const renderOrders = orders.map((order) => (
		<WaiterOrderCard
			key={order.id}
			order={order}
			useStateOrder={useStateOrder}
		/>
	));
	const renderPendingOrders = orders.map((order) => {
		if (order.status == 0) {
			return (
				<WaiterOrderCard
					key={order.id}
					order={order}
					useStateOrder={useStateOrder}
				/>
			);
		}
	});
	const renderReadyOrders = orders.map((order) => {
		if (order.status == 2) {
			return (
				<WaiterOrderCard
					key={order.id}
					order={order}
					useStateOrder={useStateOrder}
				/>
			);
		}
	});

	return (
		<section className="flex-wrap container-fluid d-flex justify-content-center">
			<div className="flex-wrap col-6 d-flex">{renderPendingOrders}</div>
			<div className="flex-wrap col-6 d-flex">{renderReadyOrders}</div>
		</section>
	);
}

export default WaiterOrderContainer;
