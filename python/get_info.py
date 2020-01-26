import json

from ev3dev.ev3 import *
from ev3dev.auto import OUTPUT_A, OUTPUT_B, OUTPUT_C, OUTPUT_D


class BrickInfo:
    def __init__(self):
        self.status = ""

    @staticmethod
    def get_motor_info(motor):
        info = dict(connected='true', address=motor.address, duty_cyle=motor.duty_cycle, position=motor.position,
                    stop_action=motor.stop_action, polarity=motor.polarity)
        return info

    def get_info(self):

        # touch sensor
        try:
            touch_sensor = TouchSensor()
            touch_data = {
                'connected': 'true',
                'address': touch_sensor.address,
                'mode': touch_sensor.mode,
                'value': touch_sensor.value()
            }
        except:
            # There is no color sensor
            touch_data = {'connected': 'false'}

        # rail motor
        try:
            rail_motor = LargeMotor('outA')
            rail_data = self.get_motor_info(rail_motor)
        except:
            # There is no color sensor
            rail_data = {'connected': 'false'}

        # paper motor
        try:
            paper_motor = LargeMotor('outB')
            paper_data = self.get_motor_info(paper_motor)
        except:
            # There is no color sensor
            paper_data = {'connected': 'false'}

        # pen motor
        try:
            pen_motor = LargeMotor('outC')
            pen_data = self.get_motor_info(pen_motor)
        except:
            # There is no color sensor
            pen_data = {'connected': 'false'}

        self.status = {
            'rail_motor': rail_data,
            'paper_motor': paper_data,
            'pen_motor': pen_data,
            'touch_sensor': touch_data,
        }

        return json.dumps(self.status)
