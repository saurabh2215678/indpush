import React from "react";
import "./Video.css";



const Video = () =>{
    return (
        <section className="pt-0">
            <div className="container">
                <div className="text-center">
                    <h2>What, Why &amp; How?</h2>
                    <div className="saperator"></div>
                    <div className="mt-4 px-3 why-desc phone">We are a team of bloggers who were frustrated by the huge recurring fees charged by SaaS brands.<br />
                        We were getting charged hundreds and sometimes thousands of dollars every month.<br />So, we came up with a solution to solve this problem by creating a self hosted push notification panel, Larapush.
                    </div>
                    <div className="box_video mt-5">
                        <div className="bg-video">
                            <img src="/images/video-image.webp" />
                            <div className="bt-play"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default Video;