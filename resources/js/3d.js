import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import { gsap } from 'gsap';

/* ------------------ Scene Setup ------------------ */

const scene = new THREE.Scene();
const bannerEl = document.getElementById('banner');

const { width, height } = getBannerSize();

const camera = new THREE.PerspectiveCamera(
    35,
    width / height,
    0.01,
    100
);
function getBannerSize() {
    return {
        width: bannerEl.clientWidth,
        height: bannerEl.clientHeight
    };
}
const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
renderer.setSize(width, height);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
document.getElementById('container3D').appendChild(renderer.domElement);

/* ------------------ Lights ------------------ */
const ambientLight = new THREE.AmbientLight(0xffffff, .5);
scene.add(ambientLight);

const topLight = new THREE.DirectionalLight(0xffffff, 1);
topLight.position.set(500, 500, 500);
scene.add(topLight);

/* ------------------ Model & Animation ------------------ */
const followerEl = document.getElementById('banner');
const screenPosition = new THREE.Vector3();

let hand, handMirror;
let mixer;
const clock = new THREE.Clock();

const loader = new GLTFLoader();
loader.load(
    '/models/robotic_hand.glb',
    (gltf) => {
        hand = gltf.scene;
        const handGroup = new THREE.Group();
        scene.add(handGroup);
        handGroup.add(hand);
        const box = new THREE.Box3().setFromObject(hand);
        const size = box.getSize(new THREE.Vector3());
        const center = box.getCenter(new THREE.Vector3());
        hand.position.sub(center);
        const maxDim = Math.max(size.x, size.y, size.z);
        const fov = THREE.MathUtils.degToRad(camera.fov);
        let cameraZ = Math.abs(maxDim / 2 / Math.tan(fov / 2));

        cameraZ *= 1;
        camera.position.set(0, 0, cameraZ);
        camera.lookAt(0, 0, 0);

        camera.near = cameraZ / 100;
        camera.far = cameraZ * 100;
        camera.updateProjectionMatrix();


        hand.rotation.set(

            THREE.MathUtils.degToRad(25),                  // X axis
            Math.PI / 1.9,         // Y axis (90°)
            0                   // Z axis
        );

        hand.scale.set(0.6, 0.6, 0.6); // start smaller

        appear(hand);




        if (gltf.animations && gltf.animations.length) {
            mixer = new THREE.AnimationMixer(hand);
            mixer.clipAction(gltf.animations[0]).play();
        }

    },
    undefined,
    (error) => console.error(error)
);

/* ------------------ Render Loop ------------------ */
const light = new THREE.DirectionalLight(0xffffff, 1);
scene.add(light);

function updateFollower(model) {
    if (!model) return;

    const rect = bannerEl.getBoundingClientRect();

    model.getWorldPosition(screenPosition);
    screenPosition.project(camera);

    const x = (screenPosition.x * 0.5 + 0.1) * rect.width;
    const y = (-screenPosition.y * 0.4 + 0.7) * rect.height;

    followerEl.style.transform = `translate(${x}px, ${y}px)`;
}

function animate() {
    requestAnimationFrame(animate);

    if (hand) { // <-- make sure hand is loaded
        updateFollower(hand);
        const alpha = THREE.MathUtils.clamp(light.intensity / 2, 0, 1);
        hand.traverse((child) => {
            if (child.isMesh && child.material.isMeshStandardMaterial) {
                child.material.color.lerpColors(
                    new THREE.Color(0xD1D1D1),
                    new THREE.Color(0xffffff),
                    alpha
                );
            }
        });
    }
    if (mixer) mixer.update(clock.getDelta());
    renderer.render(scene, camera);
}
animate();

/* ------------------ Interaction ------------------ */

function disappear(model) {
    const tl = gsap.timeline({
        onComplete: () => {
            model.visible = false; // truly gone
        }
    });

    // fade out
    model.traverse((child) => {
        if (child.isMesh) {
            tl.to(child.material, {
                opacity: 0,
                duration: 0.5,
                ease: "power2.in"
            }, 0);
        }
    });

    // zoom out (scale down)
    tl.to(model.scale, {
        x: 0.01,
        y: 0.01,
        z: 0.01,
        duration: 0.6,
        ease: "power2.in"
    }, 0);
}


function appear(model) {
    model.visible = true;


    model.traverse((child) => {
        if (child.isMesh) {
            child.material.opacity = 1;
        }
    });

    const tl = gsap.timeline();

    tl.to(model.scale, {
        x: 1,
        y: 1,
        z: 1,
        duration: 10,
        ease: "power3.out"
    });

    model.traverse((child) => {
        if (child.isMesh) {
            tl.to(child.material, {
                opacity: 1,
                duration: 10
            }, 0);
        }
    });
    gsap.to(hand.position, {
        x: "+=0.3",
        z: "+=4.2",
        duration: 20,
        ease: "sine.inOut",
        yoyo: true,
        repeat: -1
    });

    gsap.to(hand.rotation, {
        y: "+=0.01",
        duration: 2,
        ease: "sine.inOut",
        yoyo: true,
        repeat: -1
    });

}
function mirrorHand(model) {
    // mirror on X axis
    model.scale.x *= -1;

    // move it to the side so it doesn't overlap
    model.position.x += 3;

}

/* ------------------ Resize ------------------ */

window.addEventListener('resize', () => {
    const { width, height } = getBannerSize();

    camera.aspect = width / height;
    camera.updateProjectionMatrix();

    renderer.setSize(width, height);
});

